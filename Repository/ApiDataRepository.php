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

    public function fetchItemData(int $mainKey): array
    {
        $url = Constants::API_ITEM_DETAIL_URL;
        $recievedData = [];
        $getData = [
            'id' => $mainKey
        ];

        $recievedData = $this->fetchDataGet($url, $getData);

        return $recievedData;
    }

    public function fetchMultipleItemData(array $mainKeys): array
    {
        $url = Constants::API_ITEM_DETAIL_URL;
        $results = [];

        $multiHandle = curl_multi_init();
        $curlHandles = [];

        foreach ($mainKeys as $key) {
            $urlWithParams = $url . '?' . http_build_query(['id' => $key]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $urlWithParams);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[$key] = $ch;
        }

        $running = null;
        do {
            $status = curl_multi_exec($multiHandle, $running);
            if ($running) {
                curl_multi_select($multiHandle);
            }
        } while ($running && $status === CURLM_OK);

        foreach ($curlHandles as $key => $ch) {
            $response = curl_multi_getcontent($ch);

            $results[$key] = json_decode($response, true);

            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }

        curl_multi_close($multiHandle);

        return $results;
    }

    public function fetchItemsFromCategory(array $categoryData, bool $withMarketInfo = true): array
    {
        $items = [];

        foreach ($categoryData as $category) {
            $mCat = $category['mainCategory'];
            $sCat = $category['subCategory'];

            $data = $this->fetchDataFromCategory($mCat, $sCat);

            if ($withMarketInfo) {

            }

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

    public function fetchMultipleItemImageUrls(array $itemIds): array
    {
        $multiHandle = curl_multi_init();
        $curlHandles = [];
        $results = [];

        foreach ($itemIds as $itemId) {
            $url = Constants::IMG_URL . $itemId;

            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
            ]);

            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[$itemId] = $ch;
        }

        $running = null;
        do {
            $status = curl_multi_exec($multiHandle, $running);
            if ($running) {
                curl_multi_select($multiHandle);
            }
        } while ($running && $status === CURLM_OK);

        foreach ($curlHandles as $itemId => $ch) {
            $html = curl_multi_getcontent($ch);


            $results[$itemId] = null;

            if ($html) {
                $dom = new \DOMDocument();

                libxml_use_internal_errors(true);
                $dom->loadHTML($html);
                libxml_clear_errors();

                $xpath = new \DOMXPath($dom);
                $imgNode = $xpath->query("//img[contains(@class, 'item_icon')]");

                if ($imgNode->length > 0) {
                    $imgUrl = Constants::IMG_API_URL . $imgNode->item(0)->getAttribute('src');
                    $results[$itemId] = $imgUrl;
                }
            }


            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }


        curl_multi_close($multiHandle);

        return $results;
    }

}