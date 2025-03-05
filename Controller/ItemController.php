<?php

namespace Controller;

use Service\ItemService;
use Service\FavoriteItemService;
use View\LatteViewRenderer;
use Service\PaginationService;


class ItemController
{
    protected ?ItemService $itemService;
    protected ?FavoriteItemService $favoriteItemService;
    protected ?LatteViewRenderer $frontendViewhelper;
    protected ?PaginationService $paginationService;

    public function __construct()
    {
        $this->itemService = new ItemService();
        $this->favoriteItemService = new FavoriteItemService();
        $this->frontendViewhelper = new LatteViewRenderer();
        $this->paginationService = new PaginationService();
    }

    public function listAction(array $params): void
    {
        $defaultCategoryData = [['mainCategory' => 30, 'subCategory' => 1]];
        $categoryData = $this->parseCategory($params, $defaultCategoryData);
        $allItems = $this->itemService->getItemsFromCategory($categoryData);

        $page = isset($params['page'][0]) ? (int) $params['page'][0] : 1;
        $itemsPerPage = isset($params['amount'][0]) ? (int) $params['amount'][0] : 10;

        $paginationData = $this->paginationService->paginate($allItems, $page, $itemsPerPage);
        $paginationData['items'] = $this->itemService->addMarketInfoToItems($paginationData['items']);
        $paginationData['items'] = $this->itemService->addPriceHistoryToItems($paginationData['items']);

        $templateParams = array_merge(['action' => __FUNCTION__, 'user' => $_SESSION['user'] ?? null,], $paginationData);
        $this->frontendViewhelper->renderList($templateParams);
    }

    public function detailAction(array $params): void
    {
        $defaultItem = [206];

        $itemQuery = $this->itemService->getItemsByIds($params['id']);

        if (!$itemQuery) {
            $itemQuery = $this->itemService->getItemsByIds($defaultItem);
        }

        $item = $itemQuery;

        $item = $this->itemService->addMarketInfoToItems($item);
        $item = $this->itemService->addPriceHistoryToItems($item);

        $templateParams = [
            'item' => $item,
            'user' => $_SESSION['user'] ?? null,
            'action' => __FUNCTION__
        ];

        $this->frontendViewhelper->renderDetail($templateParams);
    }

    public function startAction(array $params): void
    {
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];

            $favorites = $this->favoriteItemService->getFavoritesForUser($user->getUserId());

            if ($favorites) {

                $allItems = $this->itemService->getItemsByIds($favorites);
                $allItems = $this->itemService->addMarketInfoToItems($allItems);
                $allItems = $this->itemService->addPriceHistoryToItems($allItems);

                $templateParams = [
                    'items' => $allItems,
                    'user' => $_SESSION['user'] ?? null,
                    'action' => __FUNCTION__
                ];
            } else {
                $templateParams = [
                    'items' => null,
                    'user' => $_SESSION['user'] ?? null,
                    'action' => __FUNCTION__
                ];
            }


        } else {
            $allItems = $this->itemService->getRandomItems();
            $allItems = $this->itemService->addMarketInfoToItems($allItems);
            $allItems = $this->itemService->addPriceHistoryToItems($allItems);

            $templateParams = [
                'items' => $allItems,
                'user' => null,
                'action' => __FUNCTION__
            ];
        }

        $this->frontendViewhelper->renderStart($templateParams);
    }


    public function importAction(array $params): void
    {
        $successful = $this->itemService->updateMissingPriceHistory();
        $msg = $successful ? '<p>Import abgeschlossen. Seite wird in 70 Sekunden neu geladen.</p>' : '<p>Seite wird in 70 Sekunden neu geladen.</p>';

        echo '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Import abgeschlossen</title>
            <script>
                setTimeout(function() {
                    window.location.reload();
                }, 1000 * 70);
            </script>
        </head>
        <body>
        ' . $msg . '
        </body>
        </html>';

    }

    protected function parseCategory(array $params, array $defaultCategoryData): array
    {
        if (isset($params['category']) && is_array($params['category']) && count($params['category']) === 2) {
            list($mainCategory, $subCategory) = $params['category'];
            $mainCategory = is_numeric($mainCategory) ? (int) $mainCategory : $mainCategory;
            $subCategory = is_numeric($subCategory) ? (int) $subCategory : $subCategory;
            return [['mainCategory' => $mainCategory, 'subCategory' => $subCategory]];
        }
        return $defaultCategoryData;
    }

    public function toggleFavoriteAction(array $params): void
    {
        // Setze den Header möglichst früh, um sicherzustellen, dass keine anderen Inhalte gesendet werden.
        header('Content-Type: application/json');

        // Prüfe, ob der Benutzer angemeldet ist
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Nicht angemeldet']);
            exit;
        }
        $user = $_SESSION['user'];
        $userId = $user->getUserId();

        // Hole die item_id aus den POST-Daten
        $itemId = isset($params['item_id']) ? (int) $params['item_id'] : 0;
        if ($itemId === 0) {
            echo json_encode(['success' => false, 'message' => 'Ungültige Item-ID']);
            exit;
        }

        $result = $this->favoriteItemService->toggleFavorite($userId, $itemId);

        echo json_encode($result);

        exit;
    }

}
