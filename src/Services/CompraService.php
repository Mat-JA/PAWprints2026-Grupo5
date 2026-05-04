<?php

namespace App\Services;

use PDO;
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
        $this->libroRepository = $libroRepository;
        $this->compraRepository = $compraRepository;
        $this->conexion = $conexion;
    }

    public function procesarCompra(array $datos): bool
    {
        $id_libro = (int) ($datos['id_libro'] ?? 0);

        $this->conexion->beginTransaction();

        try {
            $stockDecrementado = $this->libroRepository->decrementarStock($id_libro);

            if (!$stockDecrementado) {
                throw new StockInsuficienteException('No hay suficiente stock para el libro');
            }

            $registrado = $this->compraRepository->registrar($datos);

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
}
