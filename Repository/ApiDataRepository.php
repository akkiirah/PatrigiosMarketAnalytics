<?php

namespace Repository;

use Config\Constants;


class ApiDataRepository extends AbstractApiRepository
{
    protected string $url = '';

    protected function fetchDataFromCategory(int $mCat, int $sCat): array
    {
        $url = Constants::API_CATEGORY_URL;
        $postData = ['mainCategory' => $mCat, 'subCategory' => $sCat];
        return $this->fetchDataPost($url, $postData);
    }

    protected function fetchItemData(int $mainKey): array
    {
        $url = Constants::API_ITEM_DETAIL_URL;
        $recievedData = [];
        $getData = [
            'id' => $mainKey
        ];

        $recievedData = $this->fetchDataGet($url, $getData);

        return $recievedData;
    }

    public function fetchItemsFromCategory(array $categoryData): array
    {
        $items = [];

        foreach ($categoryData as $category) {
            $mCat = $category['mainCategory'];
            $sCat = $category['subCategory'];

            $data = $this->fetchDataFromCategory($mCat, $sCat);
            foreach ($data as $key => $value) {
                $data[$key]['marketInfo'] = $this->fetchItemData($data[$key]['id']);
            }

            // Statt das ganze $data als Element zu pushen, fügen wir die Items einzeln hinzu:
            foreach ($data as $item) {
                $items[] = $item;
            }


        }

        return $items;
    }

    public function fetchItemImageUrl(int $itemId): ?string
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

        $imgNode = $xpath->query("//img[contains(@class, 'item_icon')]");

        if ($imgNode->length > 0) {
            $imgUrl = Constants::IMG_API_URL . $imgNode->item(0)->getAttribute('src');

            return $imgUrl;
        }

        return null;
    }


}