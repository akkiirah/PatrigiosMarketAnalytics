<?php

namespace Service;

use Repository\ApiAssetRepository;
use Repository\ApiItemRepository;

class ApiService
{
    protected ?ApiAssetRepository $apiAssetRepository = null;
    protected ?ApiItemRepository $apiItemRepository = null;

    public function __construct()
    {
        $this->apiAssetRepository = new ApiAssetRepository();
        $this->apiItemRepository = new ApiItemRepository();
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
        $marketInfo = $this->apiItemRepository->fetchItemData($itemId);
        return $marketInfo;
    }
    public function fetchMultipleItemData(array $itemIds): ?array
    {
        $marketInfo = $this->apiItemRepository->fetchMultipleItemData($itemIds);
        return $marketInfo;
    }
}