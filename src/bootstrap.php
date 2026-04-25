<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;

$log_app = new Logger('log-app');
$log_app->pushHandler(new StreamHandler(__DIR__ . '/../storage/logs/app.log', LogLevel::DEBUG));

$router = new Router($log_app);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->loadRoutes('/', 'PageController@home');
$router->loadRoutes('/catalogo', 'PageController@catalogo');
$router->loadRoutes('/eventos', 'PageController@eventos');
$router->loadRoutes('/nosotros', 'PageController@acercaDeNosotros');

$router->loadRoutes('not_found', 'ErrorController@notFound');
$router->loadRoutes('internal_error', 'ErrorController@internalError');
