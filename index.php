<?php
require 'vendor/autoload.php';
session_start();


use Engine\Routing;
use Util\ErrorHandler;

ErrorHandler::register();

$routing = new Routing();

$routing->route();