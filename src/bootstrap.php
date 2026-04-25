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

$router->get('/', 'PageController@home');
$router->get('/catalogo', 'PageController@catalogo');
$router->get('/eventos', 'PageController@eventos');
$router->get('/nosotros', 'PageController@acercaDeNosotros');

$router->get('not_found', 'ErrorController@notFound');
$router->get('internal_error', 'ErrorController@internalError');
