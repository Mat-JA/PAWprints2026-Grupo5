<?php

namespace App\Controllers;

class ErrorController
{

    public string $viewsDir = __DIR__ . '/../../views';

    public function notFound()
    {
        http_response_code(404);
        require $this->viewsDir . '/pages/notFound.php'; 
    }

    public function internalError()
    {
        http_response_code(500);
        echo 'Error interno';
        //TODO crear vista
        /* require $this->viewsDir . '/pages/internal_error.php'; */
    }
}
