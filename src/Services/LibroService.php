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
}
