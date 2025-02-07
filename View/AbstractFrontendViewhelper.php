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
        $this->latte->addFilter('number_format', function ($value, $decimals = 0, $decimalSeparator = ',', $thousandSeparator = '.') {
            return number_format($value, $decimals, $decimalSeparator, $thousandSeparator);
        });
        $this->latte->setTempDirectory(Constants::DIR_CACHE);
        $this->fileName = Constants::DIR_TEMPLATES . 'template.latte';
    }
}