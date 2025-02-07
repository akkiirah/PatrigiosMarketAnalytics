<?php

namespace Repository;

use Engine\Constants;
use Model\ItemMapper;
use Model\Item;

class ApiDataRepository extends AbstractDatabase
{
    protected string $url = '';
    protected ?ItemMapper $itemMapper = null;

    public function __construct()
    {
        $this->itemMapper = new ItemMapper();
    }

    protected function fetchDataFromCategory(int $mCat, int $sCat): array
    {
        $url = Constants::API_CATEGORY_URL;
        $postData = ['mainCategory' => $mCat, 'subCategory' => $sCat];
        return $this->fetchData($url, $postData);
    }

    protected function fetchItemData(int $mainKey): array
    {
        $url = Constants::API_ITEM_DETAIL_URL;
        $postData = [
            'keyType' => 0,
            'mainKey' => $mainKey
        ];
        return $this->fetchData($url, $postData);
    }

    public function getItems(array $categoryData, array $itemNames): array
    {
        $items = []; // Array für gefundene Items

        // Durch alle übergebenen Kategorie-Daten iterieren
        foreach ($categoryData as $category) {
            $mCat = $category['mainCategory'];
            $sCat = $category['subCategory'];

            $data = $this->fetchDataFromCategory($mCat, $sCat);

            if ($data !== null) {
                foreach ($data as $value) {
                    if (in_array($value['name'], $itemNames)) {
                        $item = $value;
                        $item['itemImage'] = $this->fetchItemImageUrl($value['id']);
                        $itemMarketInfo = $this->fetchItemData($value['id']);
                        $itemObj = $this->itemMapper->createItemFromArray($item, $itemMarketInfo['resultMsg']);
                        $items[] = $itemObj;
                    }
                }
            }
        }

        return $items;
    }



    protected function fetchItemImageUrl(int $itemId): ?string
    {

        $url = Constants::IMG_URL . $itemId;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true
        ]);

        $html = curl_exec($ch);
        curl_close($ch);

        if (!$html) {
            return null;
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors(false);

        $xpath = new \DOMXPath($dom);
        $imgNode = $xpath->query("//td[@class='icon_cell']/img");

        if ($imgNode->length > 0) {
            return Constants::IMG_API_URL . $imgNode->item(0)->getAttribute('src');
        }

        return null;
    }
}