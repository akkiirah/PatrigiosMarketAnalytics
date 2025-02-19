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
    protected ?ApiAssetRepository $apiAssetRepository = null;
    protected ?ApiItemRepository $apiItemRepository = null;
    protected ?ApiMarketDataRepository $apiMarketDataRepository = null;

    protected ?FavoriteItemRepository $favoriteItemRepository = null;
    protected ?ItemRepository $itemRepository = null;
    protected ?PriceHistoryRepository $priceHistoryRepository = null;
    protected ?UserNotificationRepository $userNotificationRepository = null;
    protected ?UserRepository $userRepository = null;

    public function __construct()
    {
        $this->apiAssetRepository = new ApiAssetRepository();
        $this->apiItemRepository = new ApiItemRepository();
        $this->apiMarketDataRepository = new ApiMarketDataRepository();

        $this->favoriteItemRepository = new FavoriteItemRepository();
        $this->itemRepository = new ItemRepository();
        $this->priceHistoryRepository = new PriceHistoryRepository();
        $this->userNotificationRepository = new UserNotificationRepository();
        $this->userRepository = new UserRepository();
    }

    public function fetchItemsFromCategory(array $categoryData): array
    {
        $items = [];
        $local = [];

        $local = $this->itemRepository->getItemsByCategoryData($categoryData);

        if (isset($local[0])) {
            $items = $local;
        } else {
            $items = $this->apiItemRepository->fetchItemsFromCategory($categoryData);
        }

        return $items;
    }
    public function fetchItemsImages(array $itemIds): ?array
    {
        $itemImage = $this->apiAssetRepository->fetchMultipleItemImageUrls($itemIds);
        return $itemImage;
    }
    public function fetchItemData(int $itemId): ?array
    {
        $marketInfo = $this->apiMarketDataRepository->fetchItemMarketData($itemId);
        return $marketInfo;
    }
    public function fetchMultipleItemData(array $itemIds): ?array
    {
        $marketInfo = $this->apiMarketDataRepository->fetchMultipleItemMarketData($itemIds);
        return $marketInfo;
    }
    public function fetchMultipleItemPriceHistory(array $itemIds): ?array
    {
        $priceInfo = [];
        $missingItemIds = [];

        // Lokale Daten abfragen
        foreach ($itemIds as $itemId) {
            $localData = $this->priceHistoryRepository->getPriceHistoryForItem($itemId);

            if (!empty($localData) && is_array($localData)) {
                // Für jeden Datensatz den Preis speichern
                foreach ($localData as $record) {
                    if (isset($record['price'])) {
                        $priceInfo[$itemId][] = $record['price'];
                    }
                }
            } else {
                // Falls keine Daten vorhanden sind, Item-ID merken
                $missingItemIds[] = $itemId;
            }
        }

        // Fehlende Items per API abfragen
        if (!empty($missingItemIds)) {
            $apiData = $this->apiMarketDataRepository->fetchMultipleItemPriceData($missingItemIds);

            // Falls nur ein Item zurückkommt, könnte die API ein einzelnes Array zurückgeben,
            // also prüfen wir auf den Keys 'resultCode' und 'resultMsg'
            if (isset($apiData['resultCode']) && isset($apiData['resultMsg'])) {
                // Da nur ein Item fehlt, ordnen wir das Ergebnis dem ersten (und einzigen) fehlenden Item zu
                $apiData = [$missingItemIds[0] => $apiData];
            }

            // Jetzt verarbeiten wir die API-Daten
            foreach ($apiData as $itemId => $data) {
                if (isset($data['resultMsg'])) {
                    // Den String in einzelne Preise aufteilen (angenommen, '-' ist der Trenner)
                    $prices = explode('-', $data['resultMsg']);
                    // Optional: Umwandeln in Integer, falls gewünscht
                    $prices = array_map('intval', $prices);
                    $priceInfo[$itemId] = $prices;
                }
            }
        }

        return $priceInfo;
    }



    public function fetchMissingIdsInPriceHistory(): ?array
    {
        $missingIds = $this->priceHistoryRepository->getMissingIds();
        return $missingIds;
    }

    public function saveItemInDatabase(array $itemData): void
    {
        try {
            $this->itemRepository->insertItem($itemData);
        } catch (\PDOException $ex) {
            if (isset($ex->errorInfo[1]) && $ex->errorInfo[1] == 1062) {
                $this->itemRepository->updateItem($itemData);
            } else {
                throw $ex;
            }
        }
    }

    public function getAllItems(): array
    {
        $items = $this->itemRepository->getAllItems();
        return $items;
    }


    public function savePriceHistory(array $itemData): void
    {
        $this->priceHistoryRepository->insertOrUpdatePriceHistory($itemData);
    }

}