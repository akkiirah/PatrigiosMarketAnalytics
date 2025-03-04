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
        $item->setItemSid($dataArray['sid']);
        $item->setItemName($dataArray['name']);

        $item->setItemImage($dataArray['itemImage']);
        $item->setItemCategory($category);

        return $item;
    }

    public function addMarketInfo(Item $item, array $marketInfo): Item
    {
        $item->setItemBasePrice($this->getMarketValueList($marketInfo, 'basePrice'));
        $item->setItemCurrentStock($this->getMarketValueList($marketInfo, 'currentStock'));
        $item->setItemHardCapMin($this->getMarketValueList($marketInfo, 'priceMin'));
        $item->setItemHardCapMax($this->getMarketValueList($marketInfo, 'priceMax'));
        $item->setItemLastSalePrice($this->getMarketValueList($marketInfo, 'lastSoldPrice'));
        $relativeTime = $this->getRelativeTime($this->getMarketValueList($marketInfo, 'lastSoldTime'));
        $item->setItemLastSaleTime($relativeTime);

        return $item;
    }
    public function addPriceHistoryInfo(Item $item, array $marketInfo): Item
    {
        $i = 1;

        $marketInfoReversed = array_reverse($marketInfo);

        foreach ($marketInfoReversed as $value) {
            if (isset($value)) {
                $priceHistory["vor_{$i}"] = $value;
            }
            $i++;
        }

        $item->setItemPriceHistory($priceHistory);
        $item->setItemPriceHistoryDates($marketInfo);
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