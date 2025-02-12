<?php

namespace Repository;

use Config\Constants;

class ApiItemRepository extends AbstractApiRepository
{
    protected function fetchDataFromCategory(int $mCat, int $sCat): array
    {
        $url = Constants::API_CATEGORY_URL;
        $getData = [
            'mainCategory' => $mCat,
            'subCategory' => $sCat
        ];
        return $this->fetchData($url, $getData);
    }

    public function fetchItemsFromCategory(array $categoryData): array
    {
        $items = [];

        foreach ($categoryData as $category) {
            $mCat = $category['mainCategory'];
            $sCat = $category['subCategory'];

            $data = $this->fetchDataFromCategory($mCat, $sCat);

            foreach ($data as $item) {
                $items[] = $item;
            }
        }

        return $items;
    }
}
