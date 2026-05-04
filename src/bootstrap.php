<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;
use Dotenv\Dotenv;

use App\Core\Router;
use App\Core\Config;
use App\Core\Database\ConnectionBuilder;
use App\Core\Request;
use App\Core\Contenedor;

use App\Services\MailService;
use App\Services\ReservaService;

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

$contenedor = new Contenedor();
$contenedor->set('conexion', $connection);
$contenedor->set('logger', $log_app);

$mailService    = new MailService();
$reservaService = new ReservaService($mailService);
$contenedor->set('reservaService', $reservaService);

$request = new Request;

$router = new Router($contenedor);
$router->setLogger($log_app);

$router->get('/', 'PageController@home');
$router->get('/catalogo', 'LibroController@catalogo');
$router->get('/eventos', 'PageController@eventos');
$router->get('/nosotros', 'PageController@nosotros');

$router->get('/autores', 'AuthorsController@listAuthors');
$router->get('/autor', 'AuthorController@getAuthor');
$router->get('/autor/edit', 'AuthorController@getEdit');
$router->post('/autor/edit', 'AuthorController@setAuthor');

$router->get('/carrito', 'PageController@carrito');
$router->get('/ajustes', 'PageController@ajustes');
$router->get('/cerrarSesion', 'PageController@cerrarSesion');
$router->get('/formularioCompra',   'ReservaController@mostrar');
$router->post('/formularioCompra',  'ReservaController@procesar');
$router->get('/reserva-confirmada', 'PageController@reservaConfirmada');
$router->get('/login', 'PageController@login');
$router->get('/mi_cuenta', 'PageController@mi_cuenta');
$router->get('/misreservas', 'PageController@misreservas');
$router->get('/registrate', 'PageController@registrate');
$router->get('/libro', 'LibroController@detalle');
$router->get('/catalogo/exportar', 'LibroController@exportarCsv');

