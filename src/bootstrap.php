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
use App\Services\MailService;

// --- Infraestructura ---

$dotenv = Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();

$config = new Config();

$log = new Logger('log-app');
$handler = new StreamHandler($config->get('LOG_PATH'));
$handler->setLevel($config->get('LOG_LEVEL'));
$log->pushHandler($handler);

$connectionBuilder = new ConnectionBuilder();
$connectionBuilder->setLogger($log);
$connection = $connectionBuilder->make($config);
$mailService = new MailService();
$request = new Request();
$router = new Router();
$router->setLogger($log);

// --- Factory ---

$libroController = function () use ($connection, $mailService) {
    $libroRepo    = new \App\Repository\LibroRepository($connection);
    $autorRepo    = new \App\Repository\AutorRepository($connection);
    $libroService = new \App\Services\LibroService($libroRepo, $autorRepo);
    return new \App\Controllers\LibroController($libroService);
};

$compraController = function () use ($connection, $mailService) {
    $libroRepo     = new \App\Repository\LibroRepository($connection);
    $autorRepo     = new \App\Repository\AutorRepository($connection);
    $libroService  = new \App\Services\LibroService($libroRepo, $autorRepo);
    $compraRepo    = new \App\Repository\CompraRepository($connection);
    $compraService = new \App\Services\CompraService($libroRepo, $compraRepo, $connection);
    return new \App\Controllers\CompraController($compraService, $libroService, $mailService);
};

// --- Rutas ---

$router->get('/',                  fn() => $libroController()->home());
$router->get('/catalogo',          fn() => $libroController()->catalogo());
$router->get('/catalogo/exportar', fn() => $libroController()->exportarCsv());
$router->get('/libro',             fn() => $libroController()->detalle());
$router->get('/api/libros', fn() => $libroController()->apiGetLibros());
$router->get('/admin/abm',             fn() => $libroController()->abm());
$router->post('/admin/abm/crear',      fn() => $libroController()->crearLibro());
$router->post('/admin/abm/actualizar', fn() => $libroController()->actualizarLibro());
$router->post('/admin/abm/eliminar',   fn() => $libroController()->eliminarLibro());

$router->get('/formularioCompra', fn() => $compraController()->formularioCompra());
$router->post('/procesarCompra',  fn() => $compraController()->procesarCompra());
$router->get('/admin/pedidos',    fn() => $compraController()->pedidos());

$pageController = fn() => new \App\Controllers\PageController();

$router->get('/eventos',       fn() => $pageController()->eventos());
$router->get('/nosotros',      fn() => $pageController()->nosotros());
$router->get('/carrito',       fn() => $pageController()->carrito());
$router->get('/ajustes',       fn() => $pageController()->ajustes());
$router->get('/cerrarSesion',  fn() => $pageController()->cerrarSesion());
$router->get('/login',         fn() => $pageController()->login());
$router->get('/mi_cuenta',     fn() => $pageController()->mi_cuenta());
$router->get('/misreservas',   fn() => $pageController()->misreservas());
$router->get('/registrate',    fn() => $pageController()->registrate());
