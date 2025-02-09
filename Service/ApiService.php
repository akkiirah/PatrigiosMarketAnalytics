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

    public function fetchItemsFromCategory(array $categoryData): array
    {
        $items = $this->apiDataRepository->fetchItemsFromCategory($categoryData);
        return $items;
    }
    public function fetchItemsImages(int $itemId): ?string
    {
        $itemImage = $this->apiDataRepository->fetchItemImageUrl($itemId);
        return $itemImage;
    }
}