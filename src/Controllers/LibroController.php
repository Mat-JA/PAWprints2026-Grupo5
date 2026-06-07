<?php

namespace App\Controllers;

use App\Services\LibroService;
use App\Core\Exceptions\PageNotFound;
use Twig\Environment;

class LibroController
{
    private LibroService $libroService;
    private Environment $twig;
    public string $viewsDir;

    private ?\App\Repository\AutorRepository $autorRepository;

    public function __construct(
        LibroService $libroService,
        Environment $twig,
        ?\App\Repository\AutorRepository $autorRepository = null,
    ) {
        $this->libroService = $libroService;
        $this->twig         = $twig;
        $this->autorRepository = $autorRepository;
        $this->viewsDir = __DIR__ . '/../../views/';
    }

    public function home()
    {
        $libros = $this->libroService->obtenerTodos();

        $librosData = array_map(fn($l) => $l->fields, $libros);

        echo $this->twig->render('pages/home.twig', [
            'novedades'  => $librosData,
            'destacados' => $librosData,
        ]);
    }

    public function catalogo()
    {
        $pagina   = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
        $limite   = isset($_GET['limite']) ? (int) $_GET['limite'] : 4;
        $busqueda = $_GET['buscar'] ?? null;

        $resultado    = $this->libroService->obtenerPaginado($pagina, $limite, $busqueda);
        $libros       = $resultado['libros'];
        $totalPaginas = $resultado['totalPaginas'];
        $totalLibros  = $resultado['totalLibros'];

        if ($pagina < 1 || ($pagina > $totalPaginas && $totalLibros > 0)) {
            throw new PageNotFound('La página solicitada no existe');
        }

        echo $this->twig->render('pages/catalogo.twig', [
            'libros'       => $libros,
            'totalPaginas' => $totalPaginas,
            'totalLibros'  => $totalLibros,
            'pagina'       => $pagina,
        ]);
    }

    public function detalle()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            throw new PageNotFound('Libro no encontrado');
        }

        $libroData = $this->libroService->obtenerPorIdConAutores((int)$id);

        if (!$libroData) {
            throw new PageNotFound('Libro no encontrado');
        }

        echo $this->twig->render('pages/detalle_libro.twig', [
            'libro' => $libroData,           
        ]);
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

    /**
     * API: busca un libro en Open Library por ISBN o título.
     * Params: ?isbn=... o ?titulo=...
     */
    public function apiBuscarLibro(): void
    {
        $isbn   = $_GET['isbn'] ?? '';
        $titulo = $_GET['titulo'] ?? '';

        if (empty($isbn) && empty($titulo)) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => 'Se requiere ?isbn= o ?titulo=.']);
            exit;
        }

        if (!empty($isbn)) {
            $resultado = $this->libroService->buscarEnOpenLibrary($isbn);
        } else {
            $resultado = $this->libroService->buscarPorTituloEnOpenLibrary($titulo);
        }

        header('Content-Type: application/json');
        if (isset($resultado['error'])) {
            http_response_code(404);
        }
        echo json_encode($resultado);
        exit;
    }

    public function abm()
    {
        $librosData = $this->libroService->obtenerTodosConAutor();

        $autores = [];
        if ($this->autorRepository) {
            $autoresModels = $this->autorRepository->obtenerTodos();
            foreach ($autoresModels as $a) {
                $autores[] = $a->fields;
            }
        }

        echo $this->twig->render('pages/abm.twig', [
            'libros'  => $librosData,
            'autores' => $autores,
        ]);
    }

    public function crearLibro()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new PageNotFound('Método no permitido');
        }

        $datos = $this->_sanitizarDatos($_POST);
        $archivo = $_FILES['imagen_tapa'] ?? null;

        try {
            $this->libroService->crear($datos, $archivo);
            header('Location: /libros/abm?exito=creado');
        } catch (\InvalidArgumentException $e) {
            header('Location: /libros/abm?error=' . urlencode($e->getMessage()));
        } catch (\RuntimeException $e) {
            header('Location: /libros/abm?error=' . urlencode($e->getMessage()));
        }
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

        try {
            $this->libroService->actualizar($id, $datos, $archivo);
            header('Location: /libros/abm?exito=actualizado');
        } catch (\InvalidArgumentException $e) {
            header('Location: /libros/abm?error=' . urlencode($e->getMessage()));
        } catch (\RuntimeException $e) {
            header('Location: /libros/abm?error=' . urlencode($e->getMessage()));
        }
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

        header('Location: /libros/abm?exito=eliminado');
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
        $datos['autor_id'] = isset($post['autor_id']) && $post['autor_id'] !== ''
            ? (int) $post['autor_id']
            : null;
        return $datos;
    }
}
