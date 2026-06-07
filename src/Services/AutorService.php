<?php

namespace App\Services;

use App\Repository\AutorRepository;
use App\Models\Autor;

class AutorService
{
    private AutorRepository $autorRepository;

    public function __construct(AutorRepository $autorRepository)
    {
        $this->autorRepository = $autorRepository;
    }

    public function obtenerTodos(): array
    {
        return $this->autorRepository->obtenerTodos();
    }

    public function obtenerPorId(int $id): ?Autor
    {
        return $this->autorRepository->obtenerPorId($id);
    }

    public function crear(array $datos): int
    {
        $this->autorRepository->crear($datos);
        return $this->autorRepository->obtenerUltimoId();
    }

    public function actualizar(int $id, array $datos): bool
    {
        $autor = $this->autorRepository->obtenerPorId($id);
        if (!$autor) {
            throw new \InvalidArgumentException("El autor con id {$id} no existe.");
        }
        return $this->autorRepository->actualizar($id, $datos);
    }

    public function eliminar(int $id): bool
    {
        $autor = $this->autorRepository->obtenerPorId($id);
        if (!$autor) {
            throw new \InvalidArgumentException("El autor con id {$id} no existe.");
        }
        return $this->autorRepository->eliminar($id);
    }
}
