<?php

namespace Repository\Local;

class FavoriteItemRepository extends AbstractLocalRepository
{
    public function getFavoritesForUser(int $userId): ?array
    {
        $sql = "SELECT * FROM user_favorite_item WHERE user_id = :user_id";
        return $this->queryAll($sql, ['user_id' => $userId]);
    }

    public function addFavoriteItem(array $data): ?int
    {
        $sql = "INSERT INTO user_favorite_item (user_id, item_id) 
                VALUES (:user_id, :item_id)";
        return $this->insert($sql, $data);
    }

    public function removeFavoriteItem(int $id): int
    {
        $sql = "DELETE FROM user_favorite_item WHERE id = :id";
        return $this->delete($sql, ['id' => $id]);
    }
    public function getFavoriteForUserAndItem(int $userId, int $itemId): ?array
    {
        $sql = "SELECT * FROM user_favorite_item WHERE user_id = :user_id AND item_id = :item_id";
        return $this->query($sql, ['user_id' => $userId, 'item_id' => $itemId]);
    }
}
