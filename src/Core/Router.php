<?php

namespace App\Core;

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Exceptions\RouteNotFoundException;
use Monolog\Logger;

class Router
{
    public Logger $logger;
    public array $routes;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function dispatch($path): void
    {
        $this->logger->info("Petición a: {$path}");

        if (!array_key_exists($path, $this->routes)) {
            throw new RouteNotFoundException("No existe ruta para este Path");
        }

        list($controllerName, $method) = explode('@', $this->routes[$path]);
        $controller = new ("App\\Controllers\\PageController\\{$controllerName}");
        $controller->$method();
    }

    public function  loadRoutes($path, $action): void
    {
        $this->routes[$path] = $action;
    }
}
