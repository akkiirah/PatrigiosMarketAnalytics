<?php

namespace Model;

class ItemMapper
{
    public function createItemFromArray(array $dataArray): Item
    {
        $item = new Item();
        $item->setItemId($dataArray['id']);
        $item->setItemName($dataArray['name']);
        $item->setItemBasePrice($dataArray['basePrice']);

        return $item;
    }
}