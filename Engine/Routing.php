<?php

namespace Engine;

use Controller\ItemController;
use Model\User;

class Routing
{
    protected string $controller = '';
    protected string $action = '';
    protected array $params = [];

    public function __construct()
    {
        $this->controller = isset($_GET['controller']) ? $_GET['controller'] : 'Item';
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'Start';
        $this->params = ($_SERVER['REQUEST_METHOD'] === 'POST')
            ? $_POST
            : (isset($_GET['params']) ? $this->parseParams($_GET['params']) : []);
    }

    public function route()
    {
        $controllerClass = 'Controller\\' . $this->controller . 'Controller';
        $actionMethod = $this->action . 'Action';

        if (class_exists($controllerClass)) {
            if (method_exists($controllerClass, $actionMethod)) {
                $controllerInstance = new $controllerClass();
                $controllerInstance->$actionMethod($this->params);

            } else {
                echo 'Hoppla, Methode ' . $actionMethod . ' existiert nicht';
            }
        } else {
            echo 'Hoppla, Controller ' . $controllerClass . ' existiert nicht';
        }
    }

    private function parseParams($paramsStr): array
    {
        $paramsStr = trim($paramsStr, '{}');
        $result = [];
        $pairs = explode(',', $paramsStr);
        foreach ($pairs as $pair) {
            $pair = trim($pair);
            if (empty($pair)) {
                continue;
            }

            $parts = explode(':', $pair, 2);
            if (count($parts) < 2) {
                continue;
            }
            $key = trim($parts[0]);
            $valueStr = trim($parts[1]);

            $values = explode('-', $valueStr);
            $values = array_map(function ($value) {
                $value = trim($value);
                return (filter_var($value, FILTER_VALIDATE_INT) !== false) ? (int) $value : $value;
            }, $values);
            $result[$key] = $values;
        }
        return $result;
    }
}