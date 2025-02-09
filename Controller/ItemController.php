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

    public function control(): void
    {
        // $categoryData = [
        //     ['mainCategory' => 35, 'subCategory' => 4],
        //     ['mainCategory' => 30, 'subCategory' => 1],
        //     ['mainCategory' => 25, 'subCategory' => 6],
        //     ['mainCategory' => 20, 'subCategory' => 1],
        //     ['mainCategory' => 25, 'subCategory' => 3]
        // ];
        // $itemNames = ['Teff Sandwich', 'Lion Meat', 'Fig Pie', 'Couscous', 'Valencia Meal', 'Date Palm Wine', 'Freekeh', 'Date Palm'];        
        $categoryData = [
            ['mainCategory' => 35, 'subCategory' => 4]
        ];
        $itemNames = ['Teff Sandwich'];

        $items = $this->itemService->getItemsFromCategory($categoryData);

        $this->render($items);
    }

    public function render(array $param): void
    {
        $params = ['items' => $param];
        $this->frontendViewhelper->renderItem($params);
    }
}