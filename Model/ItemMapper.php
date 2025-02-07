<?php

namespace Model;

class ItemMapper
{
    protected ?CategoryMapper $categoryMapper = null;

    public function __construct()
    {
        $this->categoryMapper = new CategoryMapper();
    }

    public function createItemFromArray(array $dataArray, string $dataMarketArray = ''): Item
    {
        $category = $this->categoryMapper->createCategoryFromArray($dataArray);

        $item = new Item();
        $item->setItemId($dataArray['id']);
        $item->setItemName($dataArray['name']);
        $item->setItemBasePrice($dataArray['basePrice']);
        $item->setItemCurrentStock($dataArray['currentStock']);
        $item->setItemImage($dataArray['itemImage']);
        $item->setItemCategory($category);

        if ($dataMarketArray) {
            $marketInfo = $this->createItemDataFromString($dataMarketArray);

            $item->setItemHardCapMin($marketInfo['hardCapMin']);
            $item->setItemHardCapMax($marketInfo['hardCapMax']);
            $item->setItemLastSaleTime($marketInfo['lastSaleTime']);
            $item->setItemLastSalePrice($marketInfo['lastSalePrice']);
        }


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
        // Berechne die Differenz zur aktuellen Zeit
        $currentTime = time();
        $timeDiff = $currentTime - $timestamp;

        // Bestimmen, ob die Zeit in Sekunden oder Minuten oder Stunden angegeben werden soll
        if ($timeDiff < 60) {
            // Weniger als eine Minute
            return "vor " . $timeDiff . " Sekunden";
        } elseif ($timeDiff < 3600) {
            // Weniger als eine Stunde
            return "vor " . floor($timeDiff / 60) . " Minuten";
        } elseif ($timeDiff < 86400) {
            // Weniger als ein Tag
            return "vor " . floor($timeDiff / 3600) . " Stunden";
        } else {
            // Mehr als ein Tag
            return "vor " . floor($timeDiff / 86400) . " Tagen";
        }
    }
}