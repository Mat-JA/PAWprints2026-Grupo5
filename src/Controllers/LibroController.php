<?php

namespace App\Controllers;

use App\Services\LibroService;
use App\Core\Exceptions\PageNotFound;

class LibroController
{
    private LibroService $libroService;
    public string $viewsDir;

    public function __construct(
        LibroService $libroService,
    ) {
        $this->libroService = $libroService;
        $this->viewsDir = __DIR__ . '/../../views/';
    }

    public function home()
    {
        $libros = $this->libroService->obtenerTodos();
        $novedades = $libros;
        $destacados = $libros;
        require $this->viewsDir . 'pages/home.php';
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

        $libro = $this->libroService->obtenerPorIdConAutores((int)$id);

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

        echo "\xEF\xBB\xBF"; 

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

    public function apiGetLibros(): void
    {
        $libros = $this->libroService->obtenerTodosConAutor();

        header('Content-Type: application/json');
        echo json_encode($libros);
        exit;
    }

    public function abm()
    {
        $libros = $this->libroService->obtenerTodos();
        require $this->viewsDir . 'pages/abm.php';
    }

    public function crearLibro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new PageNotFound('Método no permitido');
        }

        $datos = $this->_sanitizarDatos($_POST);
        $archivo = $_FILES['imagen_tapa'] ?? null;

        $this->libroService->crear($datos, $archivo);

        header('Location: /admin/abm?exito=creado');
        exit;
    }

    public function actualizarLibro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new PageNotFound('Método no permitido');
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
        if (!$id) throw new PageNotFound('Libro no especificado');

        $datos = $this->_sanitizarDatos($_POST);
        $archivo = $_FILES['imagen_tapa'] ?? null;

        $this->libroService->actualizar($id, $datos, $archivo);

        header('Location: /admin/abm?exito=actualizado');
        exit;
    }

    public function eliminarLibro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new PageNotFound('Método no permitido');
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
        if (!$id) throw new PageNotFound('Libro no especificado');

        $this->libroService->eliminar($id);

        header('Location: /admin/abm?exito=eliminado');
        exit;
    }

    private function _sanitizarDatos(array $post): array
    {
        $campos = ['titulo', 'isbn', 'desc_corta', 'descripcion', 'fecha_pub', 'precio', 'stock'];
        $datos  = [];
        foreach ($campos as $campo) {
            $datos[$campo] = isset($post[$campo])
                ? htmlspecialchars(trim($post[$campo]), ENT_QUOTES, 'UTF-8')
                : '';
        }
        $datos['precio'] = (float) $datos['precio'];
        $datos['stock']  = (int)   $datos['stock'];
        return $datos;
    }
}
