<?php
namespace Service;

use Repository\Local\FavoriteItemRepository;

class FavoriteItemService
{
    protected FavoriteItemRepository $favoriteItemRepository;

    public function __construct()
    {
        $this->favoriteItemRepository = new FavoriteItemRepository();
    }

    /**
     * Schaltet den Favoritenstatus eines Items für einen bestimmten User um.
     *
     * @param int $userId
     * @param int $itemId
     * @return array Ergebnis mit Erfolgsmeldung und Status ("added" oder "removed")
     */
    public function toggleFavorite(int $userId, int $itemId): array
    {
        print_r('YES');
        // Prüfe, ob das Item bereits als Favorit markiert ist
        $existingFavorite = $this->favoriteItemRepository->getFavoriteForUserAndItem($userId, $itemId);

        if ($existingFavorite) {
            // Falls vorhanden, entferne den Favoriten
            $result = $this->favoriteItemRepository->removeFavoriteItem($existingFavorite['id']);
            if ($result > 0) {
                return [
                    'success' => true,
                    'message' => 'Favorit entfernt',
                    'status' => 'removed'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Fehler beim Entfernen des Favoriten'
                ];
            }
        } else {
            // Andernfalls, füge den Favoriten hinzu
            $data = [
                'user_id' => $userId,
                'item_id' => $itemId
            ];
            $insertId = $this->favoriteItemRepository->addFavoriteItem($data);
            if ($insertId) {
                return [
                    'success' => true,
                    'message' => 'Favorit hinzugefügt',
                    'status' => 'added'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Fehler beim Hinzufügen des Favoriten'
                ];
            }
        }
    }

    /**
     * Gibt alle Item-IDs der Favoriten eines Users zurück.
     *
     * @param int $userId
     * @return array Item-IDs als Array
     */
    public function getFavoritesForUser(int $userId): array
    {
        $favorites = $this->favoriteItemRepository->getFavoritesForUser($userId);
        if ($favorites) {
            return array_map(function ($fav) {
                return $fav['item_id'];
            }, $favorites);
        }
        return [];
    }
}
