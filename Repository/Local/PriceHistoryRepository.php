<?php

namespace Repository\Local;

class PriceHistoryRepository extends AbstractLocalRepository
{
    public function getPriceHistoryForItem(int $itemId): ?array
    {
        $sql = "SELECT * FROM item_price_history 
                WHERE itemId = :itemId 
                ORDER BY historyDate ASC";
        return $this->queryAll($sql, ['itemId' => $itemId]);
    }

    public function insertOrUpdatePriceHistory(array $data): ?int
    {
        $sql = "INSERT INTO item_price_history (itemId, price, historyDate)
                VALUES (:itemId, :price, :historyDate)
                ON DUPLICATE KEY UPDATE price = VALUES(price)";

        return $this->insert($sql, $data);
    }
    public function getMissingIds(): ?array
    {
        $sql = "SELECT i.id 
                FROM item i 
                LEFT JOIN item_price_history iph ON i.id = iph.itemId 
                WHERE iph.itemId IS NULL 
                LIMIT 100";

        return $this->queryAll($sql);
    }
}
