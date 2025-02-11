<?php

namespace Service;

use Repository\ApiDataRepository;

class ApiService
{
    protected ?ApiDataRepository $apiDataRepository = null;

    public function __construct()
    {
        $this->apiDataRepository = new ApiDataRepository();
    }

    public function fetchItemsFromCategory(array $categoryData, bool $withMarketInfo): array
    {
        $items = $this->apiDataRepository->fetchItemsFromCategory($categoryData, $withMarketInfo);
        return $items;
    }
    public function fetchItemsImages(array $itemIds): ?array
    {
        $itemImage = $this->apiDataRepository->fetchMultipleItemImageUrls($itemIds);
        return $itemImage;
    }
    public function fetchItemData(int $itemId): ?array
    {
        $marketInfo = $this->apiDataRepository->fetchItemData($itemId);
        return $marketInfo;
    }
    public function fetchMultipleItemData(array $itemIds): ?array
    {
        $marketInfo = $this->apiDataRepository->fetchMultipleItemData($itemIds);
        return $marketInfo;
    }
}