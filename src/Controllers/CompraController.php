<?php

namespace App\Controllers;

use App\Services\CompraService;
use App\Services\LibroService;
use App\Services\MailService;
use App\Core\Exceptions\PageNotFound;
use App\Core\Exceptions\StockInsuficienteException;
use Twig\Environment;

class CompraController
{
    private CompraService $compraService;
    private LibroService $libroService;
    private MailService $mailService;
    private Environment $twig;
    public string $viewsDir;
    private string $reservasMail;

    public function __construct(
        CompraService $compraService,
        LibroService $libroService,
        MailService $mailService,
        Environment $twig,
    ) {
        $this->compraService  = $compraService;
        $this->libroService   = $libroService;
        $this->mailService    = $mailService;
        $this->twig           = $twig;
        $this->viewsDir       = __DIR__ . '/../../views/';
        $this->reservasMail   = $_ENV['RESERVAS_MAIL'];
    }

    public function formularioCompra(): void
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new PageNotFound('Libro no encontrado');
        }

        $libro = $this->libroService->obtenerPorId((int) $id);

        if (!$libro) {
            throw new PageNotFound('Libro no encontrado');
        }

        echo $this->twig->render('pages/formularioCompra.twig', [
            'libro' => $libro->fields,
        ]);
    }
    
    public function procesarCompra(): void
    {
        $id_libro = $_POST['id_libro'] ?? null;

        if (!$id_libro) {
            throw new PageNotFound('Libro no especificado');
        }

        $datos = [];
        foreach ($_POST as $key => $value) {
            $datos[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        $datos['id_libro']  = (int) $datos['id_libro'];
        $datos['nro_calle'] = (int) $datos['nro_calle'];

        try {
            $this->compraService->procesarCompra($datos);

            $cuerpo = $this->construirEmail($datos);
            $this->mailService->send($this->reservasMail, 'Nueva Compra', $cuerpo);

            $libro = $this->libroService->obtenerPorId($datos['id_libro']);

            echo $this->twig->render('pages/compraExitosa.twig', [
                'libro'  => $libro?->fields,
                'nombre' => $datos['nombre'] ?? '',
            ]);
        } catch (StockInsuficienteException $e) {
            echo $this->twig->render('pages/stockInsuficiente.twig');
        }
    }

    public function pedidos(): void
    {
        $compras = $this->compraService->obtenerTodos();

        $comprasData = array_map(fn($c) => $c->fields, $compras);

        echo $this->twig->render('pages/pedidos.twig', [
            'compras' => $comprasData,
        ]);
    }

    private function construirEmail(array $d): string
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date('d/m/Y H:i');
        return "
            <h2>Nueva Reserva de Libro</h2>
            <h3>Datos</h3>
            <ul>
                <li><strong>Nombre:</strong> {$d['nombre']} {$d['apellido']}</li>
                <li><strong>Email:</strong> {$d['email']}</li>
                <li><strong>País:</strong> {$d['pais']}</li>
                <li><strong>Provincia:</strong> {$d['provincia']}</li>
                <li><strong>Ciudad:</strong> {$d['ciudad']}</li>
                <li><strong>Dirección:</strong> {$d['calle']} {$d['nro_calle']}</li>
            </ul>
            <p><em>Reserva creada el {$fecha}</em></p>
        ";
    }
}