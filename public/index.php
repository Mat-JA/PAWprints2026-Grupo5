<?php

/* echo "<pre>"; */
/* print_r($_SERVER); */
/* die; */

use App\Core\Exceptions\RouteNotFoundException;

require __DIR__ . '/../src/bootstrap.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->loadRoutes('/', 'PageController@home');
$router->loadRoutes('/catalogo', 'PageController@catalogo');
$router->loadRoutes('/eventos', 'PageController@eventos');
$router->loadRoutes('/nosotros', 'PageController@acercaDeNosotros');

$router->loadRoutes('not_found', 'ErrorController@notFound');
$router->loadRoutes('internal_error', 'ErrorController@internalError');

try {
    $log_app->info("Petición a: {$path}");
    $router->dispatch($path);
} catch (RouteNotFoundException $e) {
    $router->dispatch("not_found");
} catch (Exception $e) {
    $router->dispatch("internal_error");
    $log_app->error("Status Code: 500 - Internal Server Error", ["Error" => $e]);
}
