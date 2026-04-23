<?php

$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if ($path == '/') {
    require __DIR__ . '/../views/pages/index.html';
} else {
    // TODO generar codigo 404
    echo "Error: Page Not Found";
}
