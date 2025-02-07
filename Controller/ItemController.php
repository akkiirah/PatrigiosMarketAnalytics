<?php

namespace Controller;

use Repository\ApiDataRepository;
use View\FrontendViewhelper;
use Model\Item;

class ItemController
{
    protected ?ApiDataRepository $apiDataRepository;
    protected ?FrontendViewhelper $frontendViewhelper;

    public function __construct()
    {
        $this->apiDataRepository = new ApiDataRepository();
        $this->frontendViewhelper = new FrontendViewhelper();
    }

    public function control(): void
    {
        $categoryData = [
            ['mainCategory' => 35, 'subCategory' => 4],
            ['mainCategory' => 30, 'subCategory' => 1],
            ['mainCategory' => 25, 'subCategory' => 6]
        ];

        $itemNames = ['Teff Sandwich', 'Lion Meat', 'Fig Pie', 'Couscous', 'Valencia Meal', 'Date Palm Wine'];

        $items = $this->apiDataRepository->getItems($categoryData, $itemNames);

        $this->render($items);
    }

    public function render(array $param): void
    {
        $params = ['items' => $param];
        $this->frontendViewhelper->renderItem($params);
    }
}