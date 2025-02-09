<?php

namespace Service;

use Config\Constants;
use Service\CacheService;
use Model\ItemMapper;
use Model\Item;

class ItemService
{
    protected ?ApiService $apiService = null;
    protected ?ItemMapper $itemMapper = null;
    protected ?CacheService $cacheService = null;

    public function __construct()
    {
        $this->apiService = new ApiService();
        $this->itemMapper = new ItemMapper();
        $this->cacheService = new CacheService();
    }

    public function getItemsFromCategory(array $categoryData, array $itemNames = []): array
    {
        $items = $this->getAllItemsFromCategory($categoryData);

        if ($itemNames) {
            return $this->getSpecificItemsFromCategory($items, $itemNames);
        } else {
            return $items;
        }
    }

    // Only temporary since later you'll get Items by ID instead of searching through categories
    public function getSpecificItemsFromCategory(array $items, array $itemNames): array
    {
        $itemsFiltered = [];

        foreach ($items as $item) {
            if (in_array($item->getItemName(), $itemNames)) {

                $itemsFiltered[] = $item;
            }
        }
        return $itemsFiltered;
    }

    public function getAllItemsFromCategory(array $categoryData): array
    {
        $data = $this->apiService->fetchItemsFromCategory($categoryData);
        $items = [];

        foreach ($data as $key => $item) {
            $itemId = $item['id'];
            if ($this->cacheService->isImageInCache($itemId)) {
                $imgUrl = Constants::DIR_ICONS_CACHE . $itemId . '.webp';
            } else {
                $imgUrl = $this->apiService->fetchItemsImages($itemId);
                if ($imgUrl) {
                    $this->cacheService->saveImageToCache($imgUrl, $itemId);
                } else {
                    $imgUrl = Constants::DIR_ICONS_PLACEHOLDER;
                }
            }
            $item['itemImage'] = $imgUrl;
            $itemObj = $this->itemMapper->createItemFromArray($item);

            $items[] = $itemObj;
        }
        return $items;
    }
}