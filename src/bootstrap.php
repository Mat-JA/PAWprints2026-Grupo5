<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Dotenv\Dotenv;

use App\Core\Router;
use App\Core\Config;
use App\Core\Database\ConnectionBuilder;
use App\Core\Request;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();

$config = new Config();

$log_app = new Logger('log-app');
$handler = new StreamHandler($config->get('LOG_PATH'));
$handler->setLevel($config->get('LOG_LEVEL'));
$log_app->pushHandler($handler);

$connectionBuilder = new ConnectionBuilder;
$connectionBuilder->setLogger($log_app);
$connection = $connectionBuilder->make($config);

$request = new Request;

$router = new Router();
$router->setLogger($log_app);

$router->get('/', function () {
    (new \App\Controllers\PageController())->home();
});
$router->get('/eventos', function () {
    (new \App\Controllers\PageController())->eventos();
});
$router->get('/nosotros', function () {
    (new \App\Controllers\PageController())->nosotros();
});
$router->get('/carrito', function () {
    (new \App\Controllers\PageController())->carrito();
});
$router->get('/ajustes', function () {
    (new \App\Controllers\PageController())->ajustes();
});
$router->get('/cerrarSesion', function () {
    (new \App\Controllers\PageController())->cerrarSesion();
});
$router->get('/formularioCompra', function () use ($connection) {
    $repositorio = new \App\Repository\LibroRepository($connection);
    $servicio    = new \App\Services\LibroService($repositorio);
    $compraRepo  = new \App\Repository\CompraRepository($connection);
    $compraService = new \App\Services\CompraService($repositorio, $compraRepo, $connection);
    $controller  = new \App\Controllers\LibroController($servicio, $compraService);
    $controller->formularioCompra();
});
$router->get('/login', function () {
    (new \App\Controllers\PageController())->login();
});
$router->get('/mi_cuenta', function () {
    (new \App\Controllers\PageController())->mi_cuenta();
});
$router->get('/misreservas', function () {
    (new \App\Controllers\PageController())->misreservas();
});
$router->get('/registrate', function () {
    (new \App\Controllers\PageController())->registrate();
});

/* $router->get('/autores', function() { */
/*     (new \App\Controllers\AuthorsController())->listAuthors(); */
/* }); */
/* $router->get('/autor', function() { */
/*     (new \App\Controllers\AuthorController())->getAuthor(); */
/* }); */
/* $router->get('/autor/edit', function() { */
/*     (new \App\Controllers\AuthorController())->getEdit(); */
/* }); */
/* $router->post('/autor/edit', function() { */
/*     (new \App\Controllers\AuthorController())->setAuthor(); */
/* }); */

$router->get('/catalogo', function () use ($connection) {
    $repositorio = new \App\Repository\LibroRepository($connection);
    $servicio    = new \App\Services\LibroService($repositorio);
    $compraRepo  = new \App\Repository\CompraRepository($connection);
    $compraService = new \App\Services\CompraService($repositorio, $compraRepo, $connection);
    $controller  = new \App\Controllers\LibroController($servicio, $compraService);
    $controller->catalogo();
});

$router->get('/libro', function () use ($connection) {
    $repositorio = new \App\Repository\LibroRepository($connection);
    $servicio    = new \App\Services\LibroService($repositorio);
    $compraRepo  = new \App\Repository\CompraRepository($connection);
    $compraService = new \App\Services\CompraService($repositorio, $compraRepo, $connection);
    $controller  = new \App\Controllers\LibroController($servicio, $compraService);
    $controller->detalle();
});

$router->get('/catalogo/exportar', function () use ($connection) {
    $repositorio = new \App\Repository\LibroRepository($connection);
    $servicio    = new \App\Services\LibroService($repositorio);
    $compraRepo  = new \App\Repository\CompraRepository($connection);
    $compraService = new \App\Services\CompraService($repositorio, $compraRepo, $connection);
    $controller  = new \App\Controllers\LibroController($servicio, $compraService);
    $controller->exportarCsv();
});

$router->post('/procesarCompra', function () use ($connection) {
    $repositorio = new \App\Repository\LibroRepository($connection);
    $servicio    = new \App\Services\LibroService($repositorio);
    $compraRepo  = new \App\Repository\CompraRepository($connection);
    $compraService = new \App\Services\CompraService($repositorio, $compraRepo, $connection);
    $controller  = new \App\Controllers\LibroController($servicio, $compraService);
    $controller->procesarCompra();
});
