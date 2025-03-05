<?php
namespace Service;

use Config\Constants;
use Service\CacheService;
use Model\ItemMapper;
use Model\Item;

class ItemService
{
    protected ApiService $apiService;
    protected ItemMapper $itemMapper;
    protected CacheService $cacheService;

    public function __construct(
        ?ApiService $apiService = null,
        ?ItemMapper $itemMapper = null,
        ?CacheService $cacheService = null
    ) {
        $this->apiService = $apiService ?? new ApiService();
        $this->itemMapper = $itemMapper ?? new ItemMapper();
        $this->cacheService = $cacheService ?? new CacheService();
    }

    /**
     * Liefert Items aus einer Kategorie.
     */
    public function getItemsFromCategory(array $categoryData): array
    {
        // Abruf der Rohdaten (DB oder API) über den ApiService
        $rawData = $this->apiService->getItemsByCategory($categoryData);

        // Bilddaten verarbeiten (Cache prüfen, fehlende Bilder via API holen)
        $rawData = $this->processItemImages($rawData);

        $items = [];
        foreach ($rawData as $rawItem) {
            $item = $this->itemMapper->createItemFromArray($rawItem);
            $items[] = $item;

            // Optional: Item-Daten in der DB persistieren
            $this->apiService->saveItemInDatabase([
                'id' => $item->getItemId(),
                'sid' => $item->getItemSid(),
                'name' => $item->getItemName(),
                'image' => $item->getItemImage(),
                'categoryMain' => $item->getItemCategory()->getMainCategory(),
                'categorySub' => $item->getItemCategory()->getSubCategory()
            ]);
        }
        return $items;
    }

    /**
     * Liefert Items anhand einer Liste von IDs.
     */
    public function getItemsByIds(array $itemIds): array
    {
        $rawData = $this->apiService->getItemsByIds($itemIds);
        $rawData = $this->processItemImages($rawData);

        $items = [];
        foreach ($rawData as $rawItem) {
            $item = $this->itemMapper->createItemFromArray($rawItem);
            $items[$item->getItemId()] = $item;
        }
        return $items;
    }

    public function getRandomItems(): array
    {
        $rawData = $this->apiService->getRandomItems();

        $rawData = $this->processItemImages($rawData);

        $items = [];
        foreach ($rawData as $rawItem) {
            $item = $this->itemMapper->createItemFromArray($rawItem);
            $items[$item->getItemId()] = $item;
        }
        return $items;
    }

    /**
     * Liefert alle Items.
     */
    public function getAllItems(): array
    {
        $rawData = $this->apiService->getAllItems();
        $rawData = $this->processItemImages($rawData);

        $items = [];
        foreach ($rawData as $rawItem) {
            $item = $this->itemMapper->createItemFromArray($rawItem);
            $items[$item->getItemId()] = $item;
        }
        return $items;
    }

    /**
     * Fügt den Items Marktdaten hinzu.
     */
    public function addMarketInfoToItems(array $items): array
    {

        $itemIds = array_map(fn(Item $item) => $item->getItemId(), $items);
        $marketData = $this->apiService->getMarketData($itemIds);

        $newItems = [];
        foreach ($items as $item) {
            $itemId = $item->getItemId();
            $newItems[] = $this->itemMapper->addMarketInfo($item, $marketData[$itemId] ?? null);
        }
        return $newItems;
    }

    /**
     * Fügt den Items Preishistorie-Daten hinzu und speichert diese.
     */
    public function addPriceHistoryToItems(array $items): array
    {
        $itemIds = array_map(fn(Item $item) => $item->getItemId(), $items);
        $priceHistoryData = $this->apiService->getPriceHistoryData($itemIds);

        $newItems = [];
        foreach ($items as $item) {
            $itemId = $item->getItemId();
            $newItem = $this->itemMapper->addPriceHistoryInfo($item, $priceHistoryData[$itemId] ?? []);
            $this->apiService->savePriceHistory($newItem);
            $newItems[] = $newItem;
        }
        return $newItems;
    }

    /**
     * Filtert die Items nach Namen.
     */
    public function getSpecificItems(array $items, array $itemNames): array
    {
        return array_filter($items, function (Item $item) use ($itemNames) {
            return in_array($item->getItemName(), $itemNames, true);
        });
    }

    /**
     * Aktualisiert fehlende Preishistorien.
     */
    public function updateMissingPriceHistory(): bool
    {
        $missing = $this->apiService->getMissingPriceHistoryIds();
        if (empty($missing)) {
            return true;
        }

        $allItems = $this->getAllItems();
        $priceHistoryData = $this->apiService->getPriceHistoryData(
            array_map(fn($entry) => $entry['id'], $missing)
        );

        foreach ($missing as $missingEntry) {
            $missingId = $missingEntry['id'];
            if (!isset($allItems[$missingId])) {
                continue;
            }
            $item = $allItems[$missingId];
            $newItem = $this->itemMapper->addPriceHistoryInfo($item, $priceHistoryData[$missingId] ?? []);
            $this->apiService->savePriceHistory($newItem);
        }
        return true;
    }

    /**
     * Überprüft für jedes Item, ob das Bild bereits im Cache liegt; falls nicht,
     * wird über den ApiService das Bild geladen und im Cache gespeichert.
     */
    private function processItemImages(array $data): array
    {
        $nonCachedItems = [];

        foreach ($data as $key => &$item) {
            $itemId = $item['id'];
            if ($this->cacheService->isImageInCache($itemId)) {
                $item['itemImage'] = Constants::DIR_ICONS_CACHE . $itemId . '.webp';
            } else {
                $nonCachedItems[$itemId] = $key;
            }
        }
        unset($item);

        if (!empty($nonCachedItems)) {
            $nonCachedIds = array_keys($nonCachedItems);
            $fetchedImages = $this->apiService->getItemImages($nonCachedIds);
            foreach ($fetchedImages as $itemId => $imgUrl) {
                if ($imgUrl) {
                    $this->cacheService->saveImageToCache($imgUrl, $itemId);
                } else {
                    $imgUrl = Constants::DIR_ICONS_PLACEHOLDER;
                }
                $key = $nonCachedItems[$itemId];
                $data[$key]['itemImage'] = $imgUrl;
            }
        }

        return $data;
    }
}
