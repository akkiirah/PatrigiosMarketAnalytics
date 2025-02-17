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
        $priceInfo = $this->apiMarketDataRepository->fetchMultipleItemPriceData($itemIds);
        return $priceInfo;
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

    public function savePriceHistory(array $itemData): void
    {
        $this->priceHistoryRepository->insertOrUpdatePriceHistory($itemData);
    }

}