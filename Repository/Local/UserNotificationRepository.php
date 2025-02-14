<?php

namespace Repository\Local;

class UserNotificationRepository extends AbstractLocalRepository
{
    public function getNotificationsForUser(int $userId): ?array
    {
        $sql = "SELECT * FROM user_item_notification 
                WHERE user_id = :user_id AND active = 1";
        return $this->queryAll($sql, ['user_id' => $userId]);
    }

    public function addNotification(array $data): ?int
    {
        $sql = "INSERT INTO user_item_notification 
                (user_id, item_id, notification_type, price_threshold, active) 
                VALUES (:user_id, :item_id, :notification_type, :price_threshold, :active)";
        return $this->insert($sql, $data);
    }

    public function updateNotification(int $id, array $data): int
    {
        $sql = "UPDATE user_item_notification 
                SET user_id = :user_id, item_id = :item_id, notification_type = :notification_type, 
                    price_threshold = :price_threshold, active = :active 
                WHERE id = :id";
        $data['id'] = $id;
        return $this->update($sql, $data);
    }

    public function deleteNotification(int $id): int
    {
        $sql = "DELETE FROM user_item_notification WHERE id = :id";
        return $this->delete($sql, ['id' => $id]);
    }
}
