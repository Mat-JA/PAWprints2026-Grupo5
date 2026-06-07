<?php

namespace App\Controllers;

use App\Services\AutorService;
use App\Core\Exceptions\PageNotFound;
use Twig\Environment;

class AutorController
{
    private AutorService $autorService;
    private Environment $twig;

    public function __construct(AutorService $autorService, Environment $twig)
    {
        $this->autorService = $autorService;
        $this->twig         = $twig;
    }

    public function abm()
    {
        $autoresModels = $this->autorService->obtenerTodos();
        $autores = [];
        foreach ($autoresModels as $a) {
            $autores[] = $a->fields;
        }

        echo $this->twig->render('pages/autores_abm.twig', [
            'autores' => $autores,
        ]);
    }

    public function crearAutor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new PageNotFound('Método no permitido');
        }

        $datos = $this->_sanitizarDatos($_POST);

        try {
            $this->autorService->crear($datos);
            header('Location: /autores/abm?exito=creado');
        } catch (\InvalidArgumentException $e) {
            header('Location: /autores/abm?error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function actualizarAutor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new PageNotFound('Método no permitido');
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
        if (!$id) throw new PageNotFound('Autor no especificado');

        $datos = $this->_sanitizarDatos($_POST);

        try {
            $this->autorService->actualizar($id, $datos);
            header('Location: /autores/abm?exito=actualizado');
        } catch (\InvalidArgumentException $e) {
            header('Location: /autores/abm?error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    public function eliminarAutor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new PageNotFound('Método no permitido');
        }

        $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
        if (!$id) throw new PageNotFound('Autor no especificado');

        try {
            $this->autorService->eliminar($id);
            header('Location: /autores/abm?exito=eliminado');
        } catch (\InvalidArgumentException $e) {
            header('Location: /autores/abm?error=' . urlencode($e->getMessage()));
        }
        exit;
    }

    /**
     * API: crea un autor y devuelve {id, nombre} como JSON.
     * Usado desde el formulario de libros para crear autores inline.
     */
    public function apiCrearAutor()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
            exit;
        }

        $datos = $this->_sanitizarDatos($_POST);

        if (empty($datos['nombre'])) {
            http_response_code(400);
            echo json_encode(['error' => 'El nombre es obligatorio.']);
            exit;
        }

        try {
            $id = $this->autorService->crear($datos);
            header('Content-Type: application/json');
            echo json_encode(['id' => $id, 'nombre' => $datos['nombre']]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
        exit;
    }

    private function _sanitizarDatos(array $post): array
    {
        return [
            'nombre' => isset($post['nombre'])
                ? htmlspecialchars(trim($post['nombre']), ENT_QUOTES, 'UTF-8')
                : '',
            'bio' => isset($post['bio'])
                ? htmlspecialchars(trim($post['bio']), ENT_QUOTES, 'UTF-8')
                : '',
        ];
    }
}
