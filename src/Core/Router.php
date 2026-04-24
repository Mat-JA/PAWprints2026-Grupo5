<?php

namespace App\Core;

require __DIR__ . '/../../vendor/autoload.php';

use App\Core\Exceptions\RouteNotFoundException;

class Router
{
    public array $routes;

    public function dispatch($path): void
    {

        if (!array_key_exists($path, $this->routes)) {
            throw new RouteNotFoundException("No existe ruta para este Path");
        }

        list($controllerName, $method) = explode('@', $this->routes[$path]);
        $controller = new ("App\\Controllers\\{$controllerName}");
        $controller->$method();
    }

    public function  loadRoutes($path, $action): void
    {
        $this->routes[$path] = $action;
    }
}
