<?php

namespace Repository\API;

use Config\Constants;

class ApiMarketDataRepository extends AbstractApiRepository
{
    public function fetchMultipleItemMarketData(array $mainKeys): array
    {
        $url = Constants::API_ITEM_DETAIL_URL;
        $results = $this->requestDataMultiple($url, $mainKeys);
        return $results;
    }
    public function fetchMultipleItemPriceData(array $mainKeys): array
    {
        $url = Constants::API_ITEM_PRICE_HISTORY_URL;
        $results = $this->requestDataMultiple($url, $mainKeys);
        return $results;
    }
}