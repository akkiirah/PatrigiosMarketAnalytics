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

    public function getItemsFromCategory(array $categoryData): array
    {
        $items = $this->getAllItemsFromCategory($categoryData);
        return $items;
    }

    public function getItemsFromID(array $itemIds): array
    {
        $itemsArr = $this->apiService->getItemsFromID($itemIds);

        foreach ($itemsArr as $key => &$item) {
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

            $fetchedImages = $this->apiService->fetchItemsImages($nonCachedIds);

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

        $items = [];
        foreach ($itemsArr as $item) {
            $itemObj = $this->itemMapper->createItemFromArray($item);
            $items[$itemObj->getItemId()] = $itemObj;
        }

        return $items;
    }

    public function getAllItems(): array
    {
        $itemsArr = $this->apiService->getAllItems();

        foreach ($itemsArr as $key => &$item) {
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

            $fetchedImages = $this->apiService->fetchItemsImages($nonCachedIds);

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

        $items = [];
        foreach ($itemsArr as $item) {
            $itemObj = $this->itemMapper->createItemFromArray($item);
            $items[$itemObj->getItemId()] = $itemObj;
        }

        return $items;
    }

    public function addMarketInfoToItems(array $items): array
    {
        foreach ($items as $key => $item) {
            $itemIds[] = $item->getItemId();
        }

        $marketData = $this->apiService->fetchMultipleItemData($itemIds);

        foreach ($items as $item) {
            $itemId = $item->getItemId();

            $marketInfoForItem = $marketData[$itemId] ?? null;

            $newItems[] = $this->itemMapper->addMarketInfo($item, $marketInfoForItem);
        }

        return $newItems;
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

            $fetchedImages = $this->apiService->fetchItemsImages($nonCachedIds);

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

        $items = [];
        foreach ($data as $item) {
            $itemObj = $this->itemMapper->createItemFromArray($item);
            $items[] = $itemObj;

            $this->saveItemInDatabase($itemObj);
        }
        return $items;
    }

    public function addPriceHistoryToItems(array $items): array
    {
        $itemIds = [];
        foreach ($items as $item) {
            $itemIds[] = $item->getItemId();
        }

        $marketData = $this->apiService->fetchMultipleItemPriceHistory($itemIds);



        $newItems = [];
        foreach ($items as $item) {
            $itemId = $item->getItemId();
            // Sicherstellen, dass es zu diesem Item Daten gibt
            $itemMarketData = isset($marketData[$itemId]) ? $marketData[$itemId] : [];
            $newItems[] = $this->itemMapper->addPriceHistoryInfo($item, $itemMarketData);
            $this->savePriceHistory($item);
        }

        return $newItems;
    }


    public function saveItemInDatabase(Item $item): void
    {
        $itemData =
            [
                'id' => $item->getItemId(),
                'sid' => $item->getItemSid(),
                'name' => $item->getItemName(),
                'image' => $item->getItemImage(),
                'categoryMain' => $item->getItemCategory()->getMainCategory(),
                'categorySub' => $item->getItemCategory()->getSubCategory()
            ];

        $this->apiService->saveItemInDatabase($itemData);
    }
    public function updateMissingIdsInPriceHistory(): bool
    {
        $missing = $this->apiService->fetchMissingIdsInPriceHistory();
        $allItems = $this->getAllItems();
        $marketData = $this->apiService->fetchMultipleItemPriceHistory($missing);

        if (!empty($marketData)) {
            foreach ($missing as $index => $missingEntry) {
                $missingId = $missingEntry['id'];
                if (!isset($allItems[$missingId])) {
                    continue;
                }
                $item = $allItems[$missingId];
                if (isset($marketData[$index])) {
                    $itemMarketData = $marketData[$index]['resultMsg'];
                    $newItems[] = $this->itemMapper->addPriceHistoryInfo($item, $itemMarketData);
                    $this->savePriceHistory($item);
                } else {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }
    }


    public function savePriceHistory(Item $item): void
    {
        $priceHistory = $item->getItemPriceHistory();

        foreach ($priceHistory as $key => $price) {
            $daysAgo = (int) str_replace('vor_', '', $key);
            $historyDate = date('Y-m-d', strtotime("-{$daysAgo} days"));

            $itemData = [
                'itemId' => $item->getItemId(),
                'price' => $price,
                'historyDate' => $historyDate
            ];

            $this->apiService->savePriceHistory($itemData);
        }
    }
}