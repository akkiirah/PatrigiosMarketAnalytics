<?php

namespace Model;

class ItemMapper
{
    protected ?CategoryMapper $categoryMapper = null;

    public function __construct()
    {
        $this->categoryMapper = new CategoryMapper();
    }

    public function createItemFromArray(array $dataArray): Item
    {

        $category = $this->categoryMapper->createCategoryFromArray($dataArray);

        $item = new Item();
        $item->setItemId($dataArray['id']);
        $item->setItemName($dataArray['name']);
        $item->setItemBasePrice($dataArray['basePrice']);
        $item->setItemCurrentStock($dataArray['currentStock']);
        $item->setItemImage($dataArray['itemImage']);
        $item->setItemCategory($category);

        return $item;
    }

    public function addMarketInfo(Item $item, array $marketInfo): Item
    {
        $item->setItemHardCapMin($this->getMarketValueList($marketInfo, 'priceMin'));
        $item->setItemHardCapMax($this->getMarketValueList($marketInfo, 'priceMax'));
        $item->setItemLastSalePrice($this->getMarketValueList($marketInfo, 'lastSoldPrice'));
        $relativeTime = $this->getRelativeTime($this->getMarketValueList($marketInfo, 'lastSoldTime'));
        $item->setItemLastSaleTime($relativeTime);

        return $item;
    }

    private function getMarketValueList(array $marketInfo, string $key, int $default = 0)
    {
        return $marketInfo[$key] ?? ($marketInfo[0][$key] ?? $default);
    }

    private function getRelativeTime(int $timestamp): string
    {
        $currentTime = time();
        $timeDiff = $currentTime - $timestamp;

        if ($timeDiff < 60) {
            return "vor " . $timeDiff . " Sekunden";
        } elseif ($timeDiff < 3600) {
            return "vor " . floor($timeDiff / 60) . " Minuten";
        } elseif ($timeDiff < 86400) {
            return "vor " . floor($timeDiff / 3600) . " Stunden";
        } else {
            return "vor " . floor($timeDiff / 86400) . " Tagen";
        }
    }
}