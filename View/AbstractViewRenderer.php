<?php

namespace View;

use Config\Constants;


abstract class AbstractViewRenderer
{
    protected ?\Latte\Engine $latte = null;
    protected string $fileStart = '';
    protected string $fileList = '';
    protected string $fileDetail = '';

    public function __construct()
    {
        $this->latte = new \Latte\Engine;
        $this->latte->addFilter('number_format', function ($value, $decimals = 0, $decimalSeparator = ',', $thousandSeparator = '.') {
            return number_format($value, $decimals, $decimalSeparator, $thousandSeparator);
        });
        $this->latte->setTempDirectory(Constants::DIR_CACHE);
        $this->fileStart = Constants::DIR_TEMPLATES . 'start.latte';
        $this->fileList = Constants::DIR_TEMPLATES . 'list.latte';
        $this->fileDetail = Constants::DIR_TEMPLATES . 'detail.latte';
    }
}