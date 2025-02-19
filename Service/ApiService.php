<?php
namespace Service;

use Repository\API\ApiAssetRepository;
use Repository\API\ApiItemRepository;
use Repository\API\ApiMarketDataRepository;
use Repository\Local\FavoriteItemRepository;
use Repository\Local\ItemRepository;
use Repository\Local\PriceHistoryRepository;
use Repository\Local\UserNotificationRepository;
use Repository\Local\UserRepository;

class ApiService
{
    protected ApiAssetRepository $apiAssetRepository;
    protected ApiItemRepository $apiItemRepository;
    protected ApiMarketDataRepository $apiMarketDataRepository;

    protected ItemRepository $itemRepository;
    protected PriceHistoryRepository $priceHistoryRepository;
    // Weitere lokale Repositories, falls benötigt
    protected FavoriteItemRepository $favoriteItemRepository;
    protected UserNotificationRepository $userNotificationRepository;
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->apiAssetRepository = new ApiAssetRepository();
        $this->apiItemRepository = new ApiItemRepository();
        $this->apiMarketDataRepository = new ApiMarketDataRepository();

        $this->itemRepository = new ItemRepository();
        $this->priceHistoryRepository = new PriceHistoryRepository();
        $this->favoriteItemRepository = new FavoriteItemRepository();
        $this->userNotificationRepository = new UserNotificationRepository();
        $this->userRepository = new UserRepository();
    }

    /**
     * Liefert Items einer Kategorie.
     * Zuerst wird in der lokalen Datenbank gesucht, falls keine Daten vorliegen,
     * wird ein API-Aufruf getätigt.
     */
    public function getItemsByCategory(array $categoryData): array
    {
        $items = $this->itemRepository->getItemsByCategoryData($categoryData);
        if (!empty($items)) {
            return $items;
        }
        return $this->apiItemRepository->fetchItemsFromCategory($categoryData);
    }

    /**
     * Liefert Items anhand ihrer IDs.
     * Zunächst wird versucht, die Items aus der DB zu holen.
     */
    public function getItemsByIds(array $itemIds): array
    {
        $items = [];
        foreach ($itemIds as $itemId) {
            $item = $this->itemRepository->getItemById($itemId);
            if ($item) {
                $items[] = $item;
            }
        }
        // Falls nicht alle Items gefunden wurden, könnte ein API-Aufruf erfolgen:
        if (count($items) !== count($itemIds)) {
            // Hier wird angenommen, dass es eine Methode zum Abruf per API gibt:
            $apiItems = $this->apiItemRepository->fetchItemsByIds($itemIds);
            // Optional: Zusammenführen der Ergebnisse
            $items = array_merge($items, $apiItems);
        }
        return $items;
    }

    /**
     * Liefert alle Items.
     */
    public function getAllItems(): array
    {
        $items = $this->itemRepository->getAllItems();
        if (!empty($items)) {
            return $items;
        }
        return $this->apiItemRepository->fetchAllItems();
    }

    /**
     * Ruft die Bild-URLs für eine Liste von Item-IDs ab.
     */
    public function getItemImages(array $itemIds): array
    {
        return $this->apiAssetRepository->fetchMultipleItemImageUrls($itemIds);
    }

    /**
     * Ruft Marktdaten für eine Liste von Items ab.
     */
    public function getMarketData(array $itemIds): array
    {
        $rawData = $this->apiMarketDataRepository->fetchMultipleItemMarketData($itemIds);
        $marketInfo = [];

        if (!empty($rawData)) {
            // Unterstützung verschiedener Datenstrukturen
            if (isset($rawData[0]) && is_array($rawData[0]) && isset($rawData[0][0])) {
                foreach ($rawData as $outerArray) {
                    if (!is_array($outerArray)) {
                        continue;
                    }
                    foreach ($outerArray as $item) {
                        if (isset($item['id'])) {
                            $marketInfo[$item['id']] = $item;
                        }
                    }
                }
            } else {
                foreach ($rawData as $item) {
                    if (isset($item['id'])) {
                        $marketInfo[$item['id']] = $item;
                    }
                }
            }
        }
        return $marketInfo;
    }

    /**
     * Ruft Preishistorie-Daten für eine Liste von Item-IDs ab.
     * Zuerst wird in der DB gesucht; falls nicht vorhanden, erfolgt ein API-Aufruf.
     */
    public function getPriceHistoryData(array $itemIds): array
    {
        $priceInfo = [];
        $missingItemIds = [];

        foreach ($itemIds as $itemId) {
            $localData = $this->priceHistoryRepository->getPriceHistoryForItem($itemId);
            if (!empty($localData)) {
                foreach ($localData as $record) {
                    if (isset($record['price'])) {
                        $priceInfo[$itemId][] = $record['price'];
                    }
                }
            } else {
                $missingItemIds[] = $itemId;
            }
        }

        if (!empty($missingItemIds)) {
            $apiData = $this->apiMarketDataRepository->fetchMultipleItemPriceData($missingItemIds);
            // Falls API-Daten als einzelnes Array zurückkommen, anpassen:
            if (isset($apiData['resultCode'], $apiData['resultMsg'])) {
                $apiData = [$missingItemIds[0] => $apiData];
            }
            foreach ($apiData as $itemId => $data) {
                if (isset($data['resultMsg'])) {
                    // Annahme: '-' als Trenner zwischen den Preisen
                    $prices = array_map('intval', explode('-', $data['resultMsg']));
                    $priceInfo[$itemId] = $prices;
                }
            }
        }
        return $priceInfo;
    }

    /**
     * Liefert Item-IDs, für die in der Preishistorie noch keine Daten vorliegen.
     */
    public function getMissingPriceHistoryIds(): array
    {
        return $this->priceHistoryRepository->getMissingIds();
    }

    /**
     * Speichert ein Item in der Datenbank.
     */
    public function saveItemInDatabase(array $itemData): void
    {
        try {
            $this->itemRepository->insertItem($itemData);
        } catch (\PDOException $ex) {
            if (isset($ex->errorInfo[1]) && $ex->errorInfo[1] === 1062) {
                $this->itemRepository->updateItem($itemData);
            } else {
                throw $ex;
            }
        }
    }

    /**
     * Speichert die Preishistorie eines Items.
     */
    public function savePriceHistory($item): void
    {
        $priceHistory = $item->getItemPriceHistory();

        foreach ($priceHistory as $key => $price) {
            // Beispiel: Schlüssel "vor_7" → 7 Tage zurück
            $daysAgo = (int) str_replace('vor_', '', $key);
            $historyDate = date('Y-m-d', strtotime("-{$daysAgo} days"));

            $itemData = [
                'itemId' => $item->getItemId(),
                'price' => $price,
                'historyDate' => $historyDate
            ];

            $this->priceHistoryRepository->insertOrUpdatePriceHistory($itemData);
        }
    }
}
