<?php

namespace App\Controllers;

use App\Services\LibroService;
use App\Services\CompraService;
use App\Core\Exceptions\PageNotFound;
use App\Core\Exceptions\StockInsuficienteException;
use App\Services\MailService;

class LibroController
{
    private LibroService $libroService;
    private CompraService $compraService;
    private MailService $mailService;
    public string $viewsDir;

    public function __construct(LibroService $libroService, CompraService $compraService)
    {
        $this->libroService = $libroService;
        $this->compraService = $compraService;
        $this->viewsDir = __DIR__ . '/../../views/';
    }

    public function catalogo()
    {
        $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
        $limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 4;
        $busqueda = $_GET['buscar'] ?? null;

        $resultado = $this->libroService->obtenerPaginado($pagina, $limite, $busqueda);
        $libros = $resultado['libros'];
        $totalPaginas = $resultado['totalPaginas'];
        $totalLibros = $resultado['totalLibros'];

        if ($pagina < 1 || ($pagina > $totalPaginas && $totalLibros > 0)) {
            throw new PageNotFound('La página solicitada no existe');
        }

        require $this->viewsDir . 'pages/catalogo.php';
    }

    public function detalle()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new PageNotFound('Libro no encontrado');
        }

        $libro = $this->libroService->obtenerPorId((int)$id);

        if (!$libro) {
            throw new PageNotFound('Libro no encontrado');
        }

        require $this->viewsDir . 'pages/detalle_libro.php';
    }

    public function exportarCsv()
    {
        $libros = $this->libroService->obtenerTodosParaCsv();

        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=catalogo.csv');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo "\xEF\xBB\xBF"; // UTF-8 BOM

        $output = fopen('php://output', 'w');

        fputcsv($output, ['ID', 'ISBN', 'Descripcion corta', 'Stock'], ',', '"', '\\');

        foreach ($libros as $libro) {
            fputcsv($output, [
                $libro->fields['id'],
                $libro->fields['isbn'],
                $libro->fields['desc_corta'],
                $libro->fields['stock']
            ], ',', '"', '\\');
        }

        fclose($output);
        exit;
    }

    public function formularioCompra()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new PageNotFound('Libro no encontrado');
        }

        $libro = $this->libroService->obtenerPorId((int)$id);

        if (!$libro) {
            throw new PageNotFound('Libro no encontrado');
        }

        require $this->viewsDir . 'pages/formularioCompra.php';
    }

    public function procesarCompra()
    {
        $id_libro = $_POST['id_libro'] ?? null;

        if (!$id_libro) {
            throw new PageNotFound('Libro no especificado');
        }

        $datos = [];
        foreach ($_POST as $key => $value) {
            $datos[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        $datos['id_libro'] = (int) $datos['id_libro'];

        try {
            $this->compraService->procesarCompra($datos);

            $libro = $this->libroService->obtenerPorId($datos['id_libro']);
            $nombre = $datos['nombre'] ?? '';
            $cuerpo = $this->construirEmail($datos);

            $this->mailService->send($this->reservasMail, $asunto, $cuerpo);
            require $this->viewsDir . 'pages/compraExitosa.php';
        } catch (StockInsuficienteException $e) {
            require $this->viewsDir . 'pages/stockInsuficiente.php';
        }
    }

    private function construirEmail(array $d): string
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $fecha = date('d/m/Y H:i');
        return "
            <h2>Nueva Reserva de Libro</h2>

            <h3>Datos de Envío</h3>
            <ul>
                <li><strong>Nombre:</strong> {$d['envio_nombre']} {$d['envio_apellido']}</li>
                <li><strong>Email:</strong> {$d['envio_email']}</li>
                <li><strong>País:</strong> {$d['envio_pais']}</li>
                <li><strong>Provincia:</strong> {$d['envio_provincia']}</li>
                <li><strong>Ciudad:</strong> {$d['envio_ciudad']}</li>
                <li><strong>Dirección:</strong> {$d['envio_calle']} {$d['envio_nro_calle']}</li>
            </ul>

            <h3>Datos de Facturación</h3>
            <ul>
                <li><strong>Nombre:</strong> {$d['fact_nombre']} {$d['fact_apellido']}</li>
                <li><strong>Email:</strong> {$d['fact_email']}</li>
                <li><strong>País:</strong> {$d['fact_pais']}</li>
                <li><strong>Provincia:</strong> {$d['fact_provincia']}</li>
                <li><strong>Ciudad:</strong> {$d['fact_ciudad']}</li>
                <li><strong>Dirección:</strong> {$d['fact_calle']} {$d['fact_nro_calle']}</li>
                <li><strong>Vencimiento tarjeta:</strong> {$d['fact_vencimiento']}</li>
            </ul>

            <p><em>Reserva recibida el {$fecha}</em></p>
        ";
    }
}
