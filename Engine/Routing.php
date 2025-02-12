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

        // Falls der Query-Parameter "params" gesetzt ist, parsen
        $params = [];
        if (isset($_GET['params'])) {
            $params = $this->parseParams($_GET['params']);
        }

        if (class_exists($controller)) {
            if (method_exists($controller, $action)) {
                $controllerInstance = new $controller();
                $controllerInstance->$action($params);
            } else {
                echo 'Hoppla, Methode ' . $action . ' existiert nicht';
            }
        } else {
            echo 'Hoppla, Controller ' . $controller . ' existiert nicht';
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