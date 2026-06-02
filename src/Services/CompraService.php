<?php

namespace App\Services;

use PDO;
use App\Models\Compra;
use App\Repository\LibroRepository;
use App\Repository\CompraRepository;
use App\Core\Exceptions\StockInsuficienteException;

class CompraService
{
    private LibroRepository $libroRepository;
    private CompraRepository $compraRepository;
    private PDO $conexion;

    public function __construct(LibroRepository $libroRepository, CompraRepository $compraRepository, PDO $conexion)
    {
        $this->libroRepository   = $libroRepository;
        $this->compraRepository  = $compraRepository;
        $this->conexion          = $conexion;
    }

    public function procesarCompra(array $datos): bool
    {
        $compra = new Compra();
        $compra->set($datos);

        $this->conexion->beginTransaction();

        try {
            $stockDecrementado = $this->libroRepository->decrementarStock($compra->fields['id_libro']);

            if (!$stockDecrementado) {
                throw new StockInsuficienteException('No hay suficiente stock para el libro');
            }

            $registrado = $this->compraRepository->registrar($compra);

            if (!$registrado) {
                throw new \Exception('No se pudo registrar la compra');
            }

            $this->conexion->commit();
            return true;
        } catch (\Throwable $e) {
            $this->conexion->rollBack();
            throw $e;
        }
    }

    public function obtenerTodos(): array
    {
        return $this->compraRepository->obtenerTodos();
    }
}