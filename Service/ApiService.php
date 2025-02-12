<?php

namespace Service;

use Repository\ApiAssetRepository;
use Repository\ApiItemRepository;
use Repository\ApiMarketDataRepository;

class ApiService
{
    protected ?ApiAssetRepository $apiAssetRepository = null;
    protected ?ApiItemRepository $apiItemRepository = null;
    protected ?ApiMarketDataRepository $apiMarketDataRepository = null;

    public function __construct()
    {
        $this->apiAssetRepository = new ApiAssetRepository();
        $this->apiItemRepository = new ApiItemRepository();
        $this->apiMarketDataRepository = new ApiMarketDataRepository();
    }

    public function fetchItemsFromCategory(array $categoryData): array
    {
        $items = $this->apiItemRepository->fetchItemsFromCategory($categoryData);
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
}