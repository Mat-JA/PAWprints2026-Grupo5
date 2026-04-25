<?php

/* echo "<pre>"; */
/* print_r($_SERVER); */
/* die; */

use App\Core\Exceptions\RouteNotFoundException;

require __DIR__ . '/../src/bootstrap.php';

try {
    $log_app->info("Petición a: {$path}");
    $router->dispatch($path);
} catch (RouteNotFoundException $e) {
    $router->dispatch("not_found");
    $log_app->error("Status Code: 404 - Page Not Found", ["Error" => $e]);
} catch (Exception $e) {
    $router->dispatch("internal_error");
    $log_app->error("Status Code: 500 - Internal Server Error", ["Error" => $e]);
}
