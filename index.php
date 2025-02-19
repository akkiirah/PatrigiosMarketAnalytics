<?php

require 'vendor/autoload.php';

use Engine\Routing;
use Util\ErrorHandler;

ErrorHandler::register();

$routing = new Routing();

$routing->route();