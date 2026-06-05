<?php

namespace App\Controllers;
use Twig\Environment;

class ErrorController
{

    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function notFound()
    {
        http_response_code(404);
        echo $this->twig->render('pages/notFound.twig');
    }

    public function internalError()
    {
        http_response_code(500);
        echo 'Error interno';
        //TODO crear vista
        /* require $this->viewsDir . '/pages/internal_error.php'; */
    }
}
