<?php

namespace App\Controllers;

use App\Services\LibroService;
use App\Services\CompraService;
use App\Core\Exceptions\PageNotFound;
use App\Core\Exceptions\StockInsuficienteException;

class LibroController
{
    private LibroService $libroService;
    private CompraService $compraService;
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
            require $this->viewsDir . 'pages/compraExitosa.php';
        } catch (StockInsuficienteException $e) {
            require $this->viewsDir . 'pages/stockInsuficiente.php';
        }
    }
}
