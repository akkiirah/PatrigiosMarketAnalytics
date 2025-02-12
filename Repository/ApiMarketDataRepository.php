<?php

namespace Repository;

use Config\Constants;

class ApiMarketDataRepository extends AbstractApiRepository
{
    public function fetchItemMarketData(int $mainKey): array
    {
        $url = Constants::API_ITEM_DETAIL_URL;
        $getData = ['id' => $mainKey];
        return $this->fetchData($url, $getData);
    }

    public function fetchMultipleItemData(string $url, array $mainKeys): array
    {
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

    public function fetchMultipleItemMarketData(array $mainKeys): array
    {
        $url = Constants::API_ITEM_DETAIL_URL;
        $results = $this->fetchMultipleItemData($url, $mainKeys);
        return $results;
    }
    public function fetchMultipleItemPriceData(array $mainKeys): array
    {
        $url = Constants::API_ITEM_PRICE_HISTORY_URL;
        $results = $this->fetchMultipleItemData($url, $mainKeys);
        return $results;
    }
}