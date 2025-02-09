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

        $marketInfo = $this->createItemDataFromString($dataArray['marketInfo']);

        $item->setItemHardCapMin($marketInfo['hardCapMin']);
        $item->setItemHardCapMax($marketInfo['hardCapMax']);
        $item->setItemLastSaleTime($marketInfo['lastSaleTime']);
        $item->setItemLastSalePrice($marketInfo['lastSalePrice']);

        return $item;
    }

    public function createItemDataFromString(string $dataString): array
    {
        $dataArray = explode('-', $dataString);

        $hardCapMin = (int) $dataArray[6];
        $hardCapMax = (int) $dataArray[7];
        $lastSalePrice = (int) $dataArray[8];
        $lastSaleTime = (int) $dataArray[9];

        $relativeTime = $this->getRelativeTime($lastSaleTime);

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