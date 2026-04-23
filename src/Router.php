<?php

namespace Src;


class Router
{
    public function rutear(): void
    {
        $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

        if ($path == '/') {
            require __DIR__ . '/../views/pages/index.html';
        } else if ($path == '/catalogo') {
            require __DIR__ . '/../views/pages/catalogo.html';
        } else if ($path == '/eventos') {
            require __DIR__ . '/../views/pages/locales.html';
        } else if ($path == '/nosotros') {
            require __DIR__ . '/../views/pages/nosotros.html';
        } else {
            // TODO generar codigo 404
            echo "Error: Page Not Found";
        }
    }
}
