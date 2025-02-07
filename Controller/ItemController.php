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
        $item = $this->apiDataRepository->getSingleItem(35, 4);

        $this->render($item);
    }

    public function render(Item $param): void
    {
        $params = ['item' => $param];
        $this->frontendViewhelper->renderItem($params);
    }
}