<?php

namespace App\Controllers;

class PageController
{
    public string $viewsDir;

    public function __construct()
    {
        $this->viewsDir = __DIR__ . '/../../views/';
    }

    public function home()
    {
        require $this->viewsDir . 'pages/home.php';
    }

    public function catalogo()
    {
        require $this->viewsDir . 'pages/catalogo.php';
    }

    public function eventos()
    {
        require $this->viewsDir . 'pages/locales.php';
    }

    public function nosotros()
    {
        require $this->viewsDir . 'pages/nosotros.php';
    }

    public function carrito()
    {
        require $this->viewsDir . 'pages/carrito.php';
    }

    public function ajustes()
    {
        require $this->viewsDir . 'pages/ajustes.php';
    }

    public function cerrarSesion()
    {
        require $this->viewsDir . 'pages/cerrarSesion.php';
    }

    public function login()
    {
        require $this->viewsDir . 'pages/login.php';
    }

    public function mi_cuenta()
    {
        require $this->viewsDir . 'pages/mi_cuenta.php';
    }

    public function misreservas()
    {
        require $this->viewsDir . 'pages/misreservas.php';
    }

    public function registrate()
    {
        require $this->viewsDir . 'pages/registrate.php';
    }

    public function reservaConfirmada()
    {
        require $this->viewsDir . 'pages/reservaConfirmada.php';
    }
}
