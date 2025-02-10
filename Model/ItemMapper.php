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

        $marketInfo = $dataArray['marketInfo'];

        $item->setItemHardCapMin($this->getMarketValueList($marketInfo, 'priceMin'));
        $item->setItemHardCapMax($this->getMarketValueList($marketInfo, 'priceMax'));
        $item->setItemLastSalePrice($this->getMarketValueList($marketInfo, 'lastSoldPrice'));
        $relativeTime = $this->getRelativeTime($this->getMarketValueList($marketInfo, 'lastSoldTime'));
        $item->setItemLastSaleTime($relativeTime);

        return $item;
    }

    private function getMarketValueList(array $marketInfo, string $key, $default = 0)
    {
        return $marketInfo[$key] ?? ($marketInfo[0][$key] ?? $default);
    }

    public function createItemDataFromString(string $dataString): array
    {
        $dataArray = explode('-', $dataString);

        $hardCapMin = (int) $dataArray[6];
        $hardCapMax = (int) $dataArray[7];
        $lastSalePrice = (int) $dataArray[8];
        $lastSaleTime = (int) $dataArray[9];



        $data['hardCapMin'] = $hardCapMin;
        $data['hardCapMax'] = $hardCapMax;
        $data['lastSalePrice'] = $lastSalePrice;
        $data['lastSaleTime'] = $relativeTime;

        return $data;
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