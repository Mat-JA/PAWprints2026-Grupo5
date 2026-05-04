<?php

namespace App\Repository;

use PDO;

class CompraRepository
{
    private const TABLE = 'compras';

    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function registrar(array $datos): bool
    {
        $sql = "INSERT INTO " . self::TABLE .
               " (id_libro, nombre, apellido, email, pais, provincia, ciudad, calle, nro_calle)
                VALUES (:id_libro, :nombre, :apellido, :email, :pais, :provincia, :ciudad, :calle, :nro_calle)";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindValue(':id_libro', $datos['id_libro'] ?? null, PDO::PARAM_INT);
        $stmt->bindValue(':nombre', $datos['nombre'] ?? '');
        $stmt->bindValue(':apellido', $datos['apellido'] ?? '');
        $stmt->bindValue(':email', $datos['email'] ?? '');
        $stmt->bindValue(':pais', $datos['pais'] ?? '');
        $stmt->bindValue(':provincia', $datos['provincia'] ?? '');
        $stmt->bindValue(':ciudad', $datos['ciudad'] ?? '');
        $stmt->bindValue(':calle', $datos['calle'] ?? '');
        $stmt->bindValue(':nro_calle', $datos['nro_calle'] ?? '', PDO::PARAM_INT);

        return $stmt->execute();
    }
}
