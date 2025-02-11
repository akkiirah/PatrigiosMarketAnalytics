<?php

namespace Engine;

use Controller\ItemController;

class Routing
{
    protected string $controller = '';
    protected string $action = '';
    protected array $params = [];

    public function __construct()
    {
        $this->controller = isset($_GET['controller']) ? $_GET['controller'] : 'Item';
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'Start';
        $this->params = isset($_GET['params']) ? $this->parseParams($_GET['params']) : [];
    }

    public function route()
    {
        $controller = 'Controller\\' . $this->controller . 'Controller';
        $action = $this->action . 'Action';

        if (class_exists($controller)) {
            if (method_exists($controller, $action)) {
                $controllerInstance = new $controller();
                $controllerInstance->$action($this->params);
            } else {
                echo 'hoppla ' . $action . ' exisitert nich';
            }
        } else {
            echo 'hoppla ' . $controller . ' exisitert nich';
        }
    }

    private function parseParams($params): array
    {
        $params = trim($params, '{}');

        $parts = explode(':', $params, 2);
        if (count($parts) < 2) {
            return [];
        }
        $key = $parts[0];
        $valueStr = $parts[1];
        $values = explode('-', $valueStr);

        foreach ($values as &$value) {
            $value = trim($value);
            if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
                $value = (int) $value;
            }
        }
        unset($value);

        return [
            $key => $values
        ];
    }

}