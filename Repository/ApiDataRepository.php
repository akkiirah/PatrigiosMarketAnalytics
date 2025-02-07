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
        $this->url = Constants::API_URL;
        $this->itemMapper = new ItemMapper();
    }

    protected function curlData(int $mCat, int $sCat): array
    {
        $data = array(
            "mainCategory" => $mCat,
            "subCategory" => $sCat
        );

        $options = array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            )
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);

        $data = json_decode($response, true);

        curl_close($ch);

        return $data;
    }

    public function getSingleItem(int $mCat, int $sCat): ?Item
    {
        $data = $this->curlData($mCat, $sCat);

        if ($data !== null) {

            foreach ($data as $key => $value) {

                if ($value['name'] == 'Valencia Meal') {
                    $item = $value;
                }
            }

            $itemObj = $this->itemMapper->createItemFromArray($item);
            return $itemObj;
        }
        return null;
    }
}