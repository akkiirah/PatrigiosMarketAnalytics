<?php
//header('Content-Type: application/json; charset=utf8');

require 'vendor/autoload.php';

use Controller\ItemController;

$controller = new ItemController();

$controller->control();