<?php

namespace View;

use Engine\Constants;

abstract class AbstractFrontendViewhelper
{
    protected ?\Latte\Engine $latte = null;
    protected string $fileName = '';

    public function __construct()
    {
        $this->latte = new \Latte\Engine;
        $this->latte->setTempDirectory(Constants::DIR_CACHE);
        $this->fileName = Constants::DIR_TEMPLATES . 'template.latte';
    }
}