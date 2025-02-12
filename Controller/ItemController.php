<?php

namespace Controller;

use Service\ItemService;
use View\LatteViewRenderer;

class ItemController
{
    protected ?ItemService $itemService;
    protected ?LatteViewRenderer $frontendViewhelper;

    public function __construct()
    {
        $this->itemService = new ItemService();
        $this->frontendViewhelper = new LatteViewRenderer();
    }

    public function listAction($params): void
    {
        $defaultCategoryData = [
            ['mainCategory' => 30, 'subCategory' => 1]
        ];

        if (isset($params['category']) && is_array($params['category']) && count($params['category']) === 2) {
            list($mainCategory, $subCategory) = $params['category'];
            $mainCategory = is_numeric($mainCategory) ? (int) $mainCategory : $mainCategory;
            $subCategory = is_numeric($subCategory) ? (int) $subCategory : $subCategory;
            $categoryData = [
                ['mainCategory' => $mainCategory, 'subCategory' => $subCategory]
            ];
        } else {
            $categoryData = $defaultCategoryData;
        }

        $allItems = $this->itemService->getItemsFromCategory($categoryData);

        // Statt $_GET['page'] wird jetzt der Wert aus $params['page'] ausgelesen:
        $page = 1;
        if (isset($params['page']) && is_array($params['page'])) {
            $page = (int) $params['page'][0];
        }
        $itemsPerPage = 10;
        if (isset($params['amount']) && is_array($params['amount'])) {
            $itemsPerPage = (int) $params['amount'][0];
        }
        $offset = ($page - 1) * $itemsPerPage;
        $pagedItems = array_slice($allItems, $offset, $itemsPerPage);

        $pagedItems = $this->itemService->addMarketInfoToItems($pagedItems);

        $totalItems = count($allItems);
        $hasMoreItems = $totalItems > ($offset + $itemsPerPage);
        $lastPage = (int) ceil($totalItems / $itemsPerPage);
        $lastPage = $lastPage > 0 ? $lastPage : 1;

        $templateParams = [
            'items' => $pagedItems,
            'hasMoreItems' => $hasMoreItems,
            'nextPage' => $page + 1,
            'currentPage' => $page,
            'lastPage' => $lastPage,
            'action' => __FUNCTION__,
            'itemsPerPage' => $itemsPerPage
        ];

        $this->render($templateParams);
    }


    public function startAction($params): void
    {
        $categoryData = [
            ['mainCategory' => 35, 'subCategory' => 4],
            ['mainCategory' => 30, 'subCategory' => 1]
        ];

        $itemNames = ['Valencia Meal', 'King of Jungle Hamburg', 'Teff Sandwich', 'Black Stone', 'Sharp Black Crystal Shard', 'Black Gem Fragment', 'Black Gem', 'Memory Fragment', 'Caphras Stone', 'Essence of Dawn'];

        $allItems = $this->itemService->getItemsFromCategory($categoryData, $itemNames);

        $allItems = $this->itemService->addMarketInfoToItems($allItems);
        unset($item);

        $templateParams = [
            'items' => $allItems,
            'action' => __FUNCTION__
        ];

        $this->render($templateParams);
    }
    public function render(array $params): void
    {
        $this->frontendViewhelper->renderItem($params);
    }
}