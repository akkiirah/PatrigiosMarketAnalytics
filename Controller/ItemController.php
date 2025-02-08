<?php

namespace Controller;

use Repository\ApiDataRepository;
use View\FrontendViewhelper;
use Model\Item;
use View\LatteViewRenderer;

class ItemController
{
    protected ?ApiDataRepository $apiDataRepository;
    protected ?LatteViewRenderer $frontendViewhelper;

    public function __construct()
    {
        $this->apiDataRepository = new ApiDataRepository();
        $this->frontendViewhelper = new LatteViewRenderer();
    }

    public function control(): void
    {
        $categoryData = [
            ['mainCategory' => 35, 'subCategory' => 4],
            ['mainCategory' => 30, 'subCategory' => 1],
            ['mainCategory' => 25, 'subCategory' => 6],
            ['mainCategory' => 20, 'subCategory' => 1],
            ['mainCategory' => 25, 'subCategory' => 3]
        ];

        $itemNames = ['Teff Sandwich', 'Lion Meat', 'Fig Pie', 'Couscous', 'Valencia Meal', 'Date Palm Wine', 'Freekeh', 'Date Palm'];

        $items = $this->apiDataRepository->getItems($categoryData, $itemNames);

        $this->render($items);
    }

    public function render(array $param): void
    {
        $params = ['items' => $param];
        $this->frontendViewhelper->renderItem($params);
    }
}