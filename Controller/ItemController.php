<?php

namespace Controller;

use Service\ItemService;
use View\LatteViewRenderer;
use Service\PaginationService;


class ItemController
{
    protected ?ItemService $itemService;
    protected ?LatteViewRenderer $frontendViewhelper;
    protected ?PaginationService $paginationService;

    public function __construct()
    {
        $this->itemService = new ItemService();
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

        $templateParams = array_merge(['action' => __FUNCTION__], $paginationData);
        $this->frontendViewhelper->renderList($templateParams);
    }

    public function startAction(array $params): void
    {
        $categoryData = [
            ['mainCategory' => 35, 'subCategory' => 4],
            ['mainCategory' => 30, 'subCategory' => 1]
        ];

        $itemNames = [
            'Valencia Meal',
            'King of Jungle Hamburg',
            'Teff Sandwich',
            'Black Stone',
            'Sharp Black Crystal Shard',
            'Black Gem Fragment',
            'Black Gem',
            'Memory Fragment',
            'Caphras Stone',
            'Essence of Dawn'
        ];

        $allItems = $this->fetchAndPrepareItems($categoryData, $itemNames);
        $allItems = $this->itemService->addPriceHistoryToItems($allItems);

        $templateParams = [
            'items' => $allItems,
            'action' => __FUNCTION__
        ];

        $this->frontendViewhelper->renderStart($templateParams);
    }

    public function importAction(array $params): void
    {
        $successful = $this->itemService->updateMissingIdsInPriceHistory();
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

    protected function fetchAndPrepareItems(array $categoryData, ?array $itemNames = null): array
    {
        $allItems = $this->itemService->getItemsFromCategory($categoryData, $itemNames);
        return $this->itemService->addMarketInfoToItems($allItems);
    }
}
