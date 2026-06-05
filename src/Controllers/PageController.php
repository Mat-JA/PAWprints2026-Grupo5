<?php

namespace App\Controllers;

use Twig\Environment;

class PageController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function eventos(): void
    {
        echo $this->twig->render('pages/locales.twig');
    }

    public function nosotros(): void
    {
        echo $this->twig->render('pages/nosotros.twig');
    }

    public function carrito(): void
    {
        echo $this->twig->render('pages/carrito.twig');
    }

    public function ajustes(): void
    {
        echo $this->twig->render('pages/ajustes.twig');
    }

    public function cerrarSesion(): void
    {
        echo $this->twig->render('pages/cerrarSesion.twig');
    }

    public function login(): void
    {
        echo $this->twig->render('pages/login.twig');
    }

    public function mi_cuenta(): void
    {
        echo $this->twig->render('pages/mi_cuenta.twig');
    }

    public function misreservas(): void
    {
        echo $this->twig->render('pages/misreservas.twig');
    }

    public function registrate(): void
    {
        echo $this->twig->render('pages/registrate.twig');
    }
}