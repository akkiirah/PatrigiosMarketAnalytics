<?php

namespace Model;

class Item
{
    protected string $itemName = '';
    protected int $itemId = 0;
    protected int $itemBasePrice = 0;
    protected int $itemCurrentStock = 0;
    protected ?Category $itemCategory = null;


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
    public function getItemCurrentStock(): int
    {
        return $this->itemCurrentStock;
    }
    public function getItemCategory(): Category
    {
        return $this->itemCategory;
    }
    public function setItemName(string $itemName): void
    {
        $this->itemName = $itemName;
    }
    public function setItemId(int $itemId): void
    {
        $this->itemId = $itemId;
    }
    public function setItemBasePrice(int $itemBasePrice): void
    {
        $this->itemBasePrice = $itemBasePrice;
    }
    public function setItemCurrentStock(int $itemCurrentStock): void
    {
        $this->itemCurrentStock = $itemCurrentStock;
    }
    public function setItemCategory(Category $itemCategory): void
    {
        $this->itemCategory = $itemCategory;
    }
}
