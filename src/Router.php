<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\PageController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LogLevel;


class Router
{
    public PageController $page_controller;
    public Logger $log_app;

    public function __construct()
    {
        $this->log_app = new Logger('log-app');
        $this->log_app->pushHandler(new StreamHandler(__DIR__ . '/../storage/logs/app.log', LogLevel::DEBUG));
        $this->page_controller = new PageController();
    }

    public function rutear(): void
    {
        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $this->log_app->info("Petición a: {$path}");

        if ($path == '/') {
            $this->page_controller->home();
            $this->log_app->info("{$path}: Respuesta exitosa 200 OK");
        } else if ($path == '/catalogo') {
            $this->page_controller->catalogo();
            $this->log_app->info("{$path}: Respuesta exitosa 200 OK");
        } else if ($path == '/eventos') {
            $this->page_controller->eventos();
            $this->log_app->info("{$path}: Respuesta exitosa 200 OK");
        } else if ($path == '/nosotros') {
            $this->page_controller->acercaDeNosotros();
            $this->log_app->info("{$path}: Respuesta exitosa 200 OK");
        } else {
            // TODO generar codigo 404
            echo "Error: Page Not Found";
            $this->log_app->info("{$path}: Error Page Not Found 404");
        }
    }
}
