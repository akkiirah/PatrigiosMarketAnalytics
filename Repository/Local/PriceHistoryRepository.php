<?php

namespace Repository\Local;

class PriceHistoryRepository extends AbstractLocalRepository
{
    public function getPriceHistoryForItem(int $itemId): ?array
    {
        $sql = "SELECT * FROM item_price_history 
                WHERE itemId = :itemId 
                ORDER BY historyDate DESC";
        return $this->queryAll($sql, ['itemId' => $itemId]);
    }

    public function insertOrUpdatePriceHistory(array $data): ?int
    {
        $sql = "INSERT INTO item_price_history (itemId, price, historyDate)
                VALUES (:itemId, :price, :historyDate)
                ON DUPLICATE KEY UPDATE price = VALUES(price)";

        return $this->insert($sql, $data);
    }
}
