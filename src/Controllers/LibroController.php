<?php

namespace App\Controllers;

use App\Core\Contenedor;
use App\Repository\LibroRepository;
use App\Core\Exceptions\PageNotFound;

class LibroController
{
    public string $viewsDir;
    private Contenedor $contenedor;

    public function __construct(Contenedor $contenedor)
    {
        $this->contenedor = $contenedor;
        $this->viewsDir = __DIR__ . '/../../views/';
    }

    public function catalogo()
    {
        $conexion = $this->contenedor->get('conexion');

        $pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
        $limite = isset($_GET['limite']) ? (int) $_GET['limite'] : 4;
        $busqueda = $_GET['buscar'] ?? null;

        $repositorio = new LibroRepository($conexion);

        $totalLibros = $repositorio->contarLibros($busqueda);
        $totalPaginas = ceil($totalLibros / $limite);

        if ($pagina < 1 || ($pagina > $totalPaginas && $totalLibros > 0)) {
            throw new PageNotFound('La página solicitada no existe');
        }

        $libros = $repositorio->obtenerLibrosPaginados($pagina, $limite, $busqueda);

        require $this->viewsDir . 'pages/catalogo.php';
    }

    public function detalle()
    {
        $conexion = $this->contenedor->get('conexion');
        $repositorio = new LibroRepository($conexion);

        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new PageNotFound('Libro no encontrado');
        }

        $libro = $repositorio->obtenerPorId((int)$id);

        if (!$libro) {
            throw new PageNotFound('Libro no encontrado');
        }

        require $this->viewsDir . 'pages/detalle_libro.php';
    }

    public function exportarCsv()
    {
        $conexion = $this->contenedor->get('conexion');

        $repositorio = new LibroRepository($conexion);
        $libros = $repositorio->obtenerLibrosPaginados(1, 1000, null);

        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=catalogo.csv');
        header('Pragma: no-cache');
        header('Expires: 0');

        echo "\xEF\xBB\xBF"; // UTF-8 BOM

        $output = fopen('php://output', 'w');

        fputcsv($output, ['ID', 'ISBN', 'Descripcion corta', 'Precio', 'Stock'], ',', '"', '\\');

        foreach ($libros as $libro) {
            fputcsv($output, [
                $libro->fields['id'],
                $libro->fields['isbn'],
                $libro->fields['descripcion_corta'],
                $libro->fields['precio'],
                $libro->fields['stock']
            ], ',', '"', '\\');
        }

        fclose($output);
        exit;
    }
    
}