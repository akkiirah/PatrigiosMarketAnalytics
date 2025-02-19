<?php

namespace Model;

class Item
{
    protected string $itemName = '';
    protected int $itemId = 0;
    protected ?int $itemSid = 0;
    protected int $itemBasePrice = 0;
    protected int $itemLastSalePrice = 0;
    protected int $itemCurrentStock = 0;
    protected int $itemHardCapMin = 0;
    protected int $itemHardCapMax = 0;
    protected string $itemLastSaleTime = '';
    protected string $itemImage = '';
    protected ?Category $itemCategory = null;
    protected array $itemPriceHistory = [];
    protected array $itemPriceHistoryDates = [];


    public function getItemName(): string
    {
        return $this->itemName;
    }
    public function getItemId(): int
    {
        return $this->itemId;
    }
    public function getItemSid(): ?int
    {
        return $this->itemSid;
    }
    public function getItemBasePrice(): int
    {
        return $this->itemBasePrice;
    }
    public function getItemLastSalePrice(): int
    {
        return $this->itemLastSalePrice;
    }
    public function getItemCurrentStock(): int
    {
        return $this->itemCurrentStock;
    }
    public function getItemCategory(): Category
    {
        return $this->itemCategory;
    }
    public function getItemImage(): string
    {
        return $this->itemImage;
    }
    public function getItemLastSaleTime(): string
    {
        return $this->itemLastSaleTime;
    }
    public function getItemHardCapMax(): int
    {
        return $this->itemHardCapMax;
    }
    public function getItemHardCapMin(): int
    {
        return $this->itemHardCapMin;
    }
    public function getItemPriceHistory(): array
    {
        return $this->itemPriceHistory;
    }
    public function getItemPriceHistoryDates(): array
    {
        return $this->itemPriceHistoryDates;
    }
    public function setItemName(string $itemName): void
    {
        $this->itemName = $itemName;
    }
    public function setItemId(int $itemId): void
    {
        $this->itemId = $itemId;
    }
    public function setItemSid(?int $itemSid): void
    {
        $this->itemSid = $itemSid;
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
    public function setItemImage(?string $itemImage): void
    {
        $this->itemImage = $itemImage ?? '';
    }
    public function setItemLastSaleTime(string $itemLastSaleTime): void
    {
        $this->itemLastSaleTime = $itemLastSaleTime;
    }
    public function setItemHardCapMax(int $itemHardCapMax): void
    {
        $this->itemHardCapMax = $itemHardCapMax;
    }
    public function setItemHardCapMin(int $itemHardCapMin): void
    {
        $this->itemHardCapMin = $itemHardCapMin;
    }
    public function setItemLastSalePrice(int $itemLastSalePrice): void
    {
        $this->itemLastSalePrice = $itemLastSalePrice;
    }
    public function setItemPriceHistory(array $itemPriceHistory): void
    {
        $this->itemPriceHistory = $itemPriceHistory;
    }
    public function setItemPriceHistoryDates(array $itemPriceHistoryDates): void
    {
        $this->itemPriceHistoryDates = $itemPriceHistoryDates;
    }
}
