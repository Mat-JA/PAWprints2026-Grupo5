<?php

namespace App\Core;

require __DIR__ . '/../../vendor/autoload.php';

use Exception;

use App\Core\Exceptions\RouteNotFoundException;
use App\Core\Request;
use App\Core\Traits\Loggable;
use App\Core\Exceptions\PageNotFound;

class Router
{
    use Loggable;

    public array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    public string $notFound = 'not_found';
    public string $internalError = 'internal_error';

    public function __construct()
    {
        $this->get($this->notFound, function() {
            (new \App\Controllers\ErrorController())->notFound();
        });
        $this->get($this->internalError, function() {
            (new \App\Controllers\ErrorController())->internalError();
        });
    }

    public function loadRoutes(string $path, callable $action, string $http_method = 'GET'): void
    {
        $this->routes[$http_method][$path] = $action;
    }

    public function get(string $path, callable $action): void
    {
        $this->loadRoutes($path, $action, 'GET');
    }

    public function post(string $path, callable $action): void
    {
        $this->loadRoutes($path, $action, 'POST');
    }

    public function dispatch(Request $request): void
    {
        try {
            [$path, $http_method] = $request->route();

            if (!$this->routeExists($path, $http_method)) {
                throw new RouteNotFoundException('No existe ruta para este Path');
            }

            $this->logger->info('Status Code: 200 OK', ['Path' => $path, 'Method' => $http_method]);

            ($this->routes[$http_method][$path])();

        } catch (RouteNotFoundException | PageNotFound $e) {
            $this->logger->debug('Status Code: 404 - Page Not Found', ['ERROR' => $e]);
            ($this->routes['GET'][$this->notFound])();

        } catch (Exception $e) {
            $this->logger->debug('Status Code: 500 - Internal Server Error', ['ERROR' => $e]);
            ($this->routes['GET'][$this->internalError])();
        }
    }

    public function routeExists(string $path, string $http_method): bool
    {
        return array_key_exists($path, $this->routes[$http_method]);
    }
}
