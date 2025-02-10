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
        if ($params && isset($params['category']) && is_array($params['category']) && count($params['category']) === 2) {
            list($mainCategory, $subCategory) = $params['category'];

            $mainCategory = is_numeric($mainCategory) ? (int) $mainCategory : $mainCategory;
            $subCategory = is_numeric($subCategory) ? (int) $subCategory : $subCategory;

            $categoryData = [
                ['mainCategory' => $mainCategory, 'subCategory' => $subCategory]
            ];
        } else {
            $categoryData = $defaultCategoryData;
        }
        //$itemNames = ['Black Stone', 'Concentrated Magical Black Gem', 'Memory Fragment', 'Caphras Stone'];

        $items = $this->itemService->getItemsFromCategory($categoryData);

        $this->render($items);
    }

    public function render(array $param): void
    {
        $params = ['items' => $param];
        $this->frontendViewhelper->renderItem($params);
    }
}