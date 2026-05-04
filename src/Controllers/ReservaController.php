<?php

namespace App\Controllers;

use App\Core\Contenedor;

class ReservaController
{
    private string $viewsDir;
    private Contenedor $contenedor;

    public function __construct(Contenedor $contenedor)
    {
        $this->contenedor = $contenedor;
        $this->viewsDir   = __DIR__ . '/../../views/';
    }

    /**
     * GET /formularioCompra
     * Muestra el formulario vacío
     */
    public function mostrar(): void
    {
        $errores = [];
        require $this->viewsDir . 'pages/formularioCompra.php';
    }

    /**
     * POST /formularioCompra
     * Procesa el envío del formulario
     */
    public function procesar(): void
    {
        $datos = [
            'envio_nombre'     => trim($_POST['envio_nombre']     ?? ''),
            'envio_apellido'   => trim($_POST['envio_apellido']   ?? ''),
            'envio_email'      => trim($_POST['envio_email']      ?? ''),
            'envio_pais'       => trim($_POST['envio_pais']       ?? ''),
            'envio_provincia'  => trim($_POST['envio_provincia']  ?? ''),
            'envio_ciudad'     => trim($_POST['envio_ciudad']     ?? ''),
            'envio_calle'      => trim($_POST['envio_calle']      ?? ''),
            'envio_nro_calle'  => trim($_POST['envio_nro_calle']  ?? ''),
            'fact_nombre'      => trim($_POST['fact_nombre']      ?? ''),
            'fact_apellido'    => trim($_POST['fact_apellido']    ?? ''),
            'fact_email'       => trim($_POST['fact_email']       ?? ''),
            'fact_pais'        => trim($_POST['fact_pais']        ?? ''),
            'fact_provincia'   => trim($_POST['fact_provincia']   ?? ''),
            'fact_ciudad'      => trim($_POST['fact_ciudad']      ?? ''),
            'fact_calle'       => trim($_POST['fact_calle']       ?? ''),
            'fact_nro_calle'   => trim($_POST['fact_nro_calle']   ?? ''),
            'fact_nro_tarjeta' => trim($_POST['fact_nro_tarjeta'] ?? ''),
            'fact_vencimiento' => trim($_POST['fact_vencimiento'] ?? ''),
        ];

        try {
            $service = $this->contenedor->get('reservaService');
            $service->procesarReserva($datos);

            header('Location: /reserva-confirmada');
            exit;

        } catch (\InvalidArgumentException $e) {
            $errores = [$e->getMessage()];
            require $this->viewsDir . 'pages/formularioCompra.php';

        } catch (\Exception $e) {
            //$errores = [$e->getMessage()];
            $errores = ['Ocurrió un error al procesar la reserva. Intente nuevamente.'];
            require $this->viewsDir . 'pages/formularioCompra.php';
}
    }
}