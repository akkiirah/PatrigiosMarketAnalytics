<?php

namespace Controller;

use Service\ItemService;
use View\LatteViewRenderer;
use Service\PaginationService;


class UserController
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

    public function loginAction(array $params): void
    {
        $templateParams = [
            'action' => __FUNCTION__
        ];

        $this->frontendViewhelper->renderLogin($templateParams);
    }

    public function registerAction(array $params): void
    {
        $templateParams = [
            'action' => __FUNCTION__
        ];

        $this->frontendViewhelper->renderRegister($templateParams);
    }
}
