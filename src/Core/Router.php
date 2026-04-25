<?php

namespace App\Core;

require __DIR__ . '/../../vendor/autoload.php';

use App\Core\Exceptions\RouteNotFoundException;

class Router
{
    public array $routes = [
        "GET" => [],
        "POST" => [],
    ];

    public function dispatch($path, $http_method = "GET"): void
    {

        if (!$this->routeExists($path, $http_method)) {
            throw new RouteNotFoundException("No existe ruta para este Path");
        }

        list($controllerName, $method) = $this->getController($path, $http_method);
        $controller = new ("App\\Controllers\\{$controllerName}");
        $controller->$method();
    }

    public function getController($path, $http_method)
    {
        return explode('@', $this->routes[$http_method][$path]);
    }

    public function loadRoutes($path, $action, $http_method = "GET"): void
    {
        $this->routes[$http_method][$path] = $action;
    }

    public function get($path, $action)
    {
        $this->loadRoutes($path, $action, "GET");
    }

    public function post($path, $action)
    {
        $this->loadRoutes($path, $action, "POST");
    }

    public function routeExists($path, $http_method): bool
    {
        return (array_key_exists($path, $this->routes[$http_method]));
    }
}
