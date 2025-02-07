<?php

namespace Model;

class Item
{
    protected string $itemName = '';
    protected int $itemId = 0;
    protected int $itemBasePrice = 0;

    public function getItemName(): string
    {
        return $this->itemName;
    }
    public function getItemId(): int
    {
        return $this->itemId;
    }
    public function getItemBasePrice(): int
    {
        return $this->itemBasePrice;
    }
    public function setItemName(string $itemName): void
    {
        $this->itemName = $itemName;
    }
    public function setItemId(int $itemId): void
    {
        $this->itemId = $itemId;
    }
    public function setItemBasePrice($itemBasePrice): void
    {
        $this->itemBasePrice = $itemBasePrice;
    }
}
