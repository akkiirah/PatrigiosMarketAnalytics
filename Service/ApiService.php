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

    public function fetchMultipleItemData(array $itemIds): ?array
    {
        $rawData = $this->apiMarketDataRepository->fetchMultipleItemMarketData($itemIds);

        if (empty($rawData)) {
            error_log('fetchMultipleItemData: Keine Daten von fetchMultipleItemMarketData erhalten.');
            return [];
        }

        if (isset($rawData[0]) && is_array($rawData[0]) && isset($rawData[0][0])) {
            $marketInfo = [];
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
            $marketInfo = [];
            foreach ($rawData as $item) {
                if (isset($item['id'])) {
                    $marketInfo[$item['id']] = $item;
                }
            }
        }

        return $marketInfo;
    }


    public function fetchMultipleItemPriceHistory(array $itemIds): ?array
    {
        $priceInfo = [];
        $missingItemIds = [];

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

            if (isset($apiData['resultCode']) && isset($apiData['resultMsg'])) {
                $apiData = [$missingItemIds[0] => $apiData];
            }



            foreach ($apiData as $itemId => $data) {
                if (isset($data['resultMsg'])) {
                    // Den String in einzelne Preise aufteilen (angenommen, '-' ist der Trenner)
                    $prices = explode('-', $data['resultMsg']);
                    // Optional: Umwandeln in Integer, falls gewünscht
                    $prices = array_map('intval', $prices);
                    $priceInfo[$missingItemIds[$itemId]] = $prices;

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

    public function getItemsFromID(array $itemIds): array
    {
        $items = [];
        foreach ($itemIds as $key => $itemId) {
            $items[] = $this->itemRepository->getItemById($itemId);
        }

        return $items;
    }


    public function savePriceHistory(array $itemData): void
    {
        $this->priceHistoryRepository->insertOrUpdatePriceHistory($itemData);
    }

}