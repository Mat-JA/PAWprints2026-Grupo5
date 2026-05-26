<?php

namespace App\Services;

use App\Repository\LibroRepository;
use App\Models\Libro;

class LibroService
{
    private LibroRepository $libroRepository;

    public function __construct(LibroRepository $libroRepository)
    {
        $this->libroRepository = $libroRepository;
    }

    public function obtenerPaginado(int $pagina, int $limite, ?string $busqueda): array
    {
        $totalLibros = $this->libroRepository->contarLibros($busqueda);
        $totalPaginas = (int) ceil($totalLibros / $limite);
        $libros = $this->libroRepository->obtenerLibrosPaginados($pagina, $limite, $busqueda);
        return [
            'libros' => $libros,
            'totalPaginas' => $totalPaginas,
            'totalLibros' => $totalLibros,
        ];
    }

    public function obtenerPorId(int $id): ?Libro
    {
        return $this->libroRepository->obtenerPorId($id);
    }

    public function obtenerTodosParaCsv(): array
    {
        return $this->libroRepository->obtenerLibrosPaginados(1, 1000, null);
    }

    public function obtenerTodos(): array
    {
        return $this->libroRepository->obtenerTodos();
    }

    public function crear(array $datos, ?array $archivo): bool
    {
        $datos['imagen_url'] = $this->_procesarImagen(null, $archivo);
        return $this->libroRepository->crear($datos);
    }

    public function actualizar(int $id, array $datos, ?array $archivo): bool
    {
        $libro = $this->libroRepository->obtenerPorId($id);
        if (!$libro) {
            throw new \InvalidArgumentException("El libro con id {$id} no existe.");
        }

        // Si no se subió imagen nueva, mantener la existente
        $datos['imagen_url'] = $this->_procesarImagen($libro->fields['imagen_url'], $archivo);

        return $this->libroRepository->actualizar($id, $datos);
    }

    public function eliminar(int $id): bool
    {
        $libro = $this->libroRepository->obtenerPorId($id);
        if (!$libro) {
            throw new \InvalidArgumentException("El libro con id {$id} no existe.");
        }
        return $this->libroRepository->eliminar($id);
    }

    private function _procesarImagen(?string $imagenActual, ?array $archivo): string
    {
        // Si no hay archivo nuevo, devolver la imagen actual
        if (!$archivo || $archivo['error'] !== UPLOAD_ERR_OK) {
            return $imagenActual ?? '';
        }

        // Validar tipo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($archivo['type'], $tiposPermitidos)) {
            throw new \InvalidArgumentException("Tipo de archivo no permitido.");
        }

        // Validar tamaño (máx 5 MB)
        if ($archivo['size'] > 5 * 1024 * 1024) {
            throw new \InvalidArgumentException("El archivo supera el tamaño máximo (5 MB).");
        }

        // Crear directorio si no existe
        $uploadDir = __DIR__ . '/../../public/assets/img/tapas/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Nombre único
        $extension    = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombreArchivo = 'libro_' . time() . '_' . uniqid() . '.' . $extension;
        $rutaDestino  = $uploadDir . $nombreArchivo;

        if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            throw new \RuntimeException("No se pudo guardar la imagen.");
        }

        return '/assets/img/tapas/' . $nombreArchivo;
    }
}
