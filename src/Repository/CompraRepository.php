<?php

namespace App\Repository;

use PDO;
use App\Models\Compra;

class CompraRepository
{
    private const TABLE = 'compras';

    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function registrar(Compra $compra): bool
    {
        $sql = "INSERT INTO " . self::TABLE .
               " (id_libro, nombre, apellido, email, pais, provincia, ciudad, calle, nro_calle)
                VALUES (:id_libro, :nombre, :apellido, :email, :pais, :provincia, :ciudad, :calle, :nro_calle)";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindValue(':id_libro',  $compra->fields['id_libro'],  PDO::PARAM_INT);
        $stmt->bindValue(':nombre',    $compra->fields['nombre']);
        $stmt->bindValue(':apellido',  $compra->fields['apellido']);
        $stmt->bindValue(':email',     $compra->fields['email']);
        $stmt->bindValue(':pais',      $compra->fields['pais']);
        $stmt->bindValue(':provincia', $compra->fields['provincia']);
        $stmt->bindValue(':ciudad',    $compra->fields['ciudad']);
        $stmt->bindValue(':calle',     $compra->fields['calle']);
        $stmt->bindValue(':nro_calle', $compra->fields['nro_calle'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function obtenerTodos(): array
    {
        $sql = "SELECT c.*, l.titulo AS titulo_libro
                FROM " . self::TABLE . " c
                LEFT JOIN libros l ON c.id_libro = l.id
                ORDER BY c.id DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $compras = [];
        foreach ($filas as $fila) {
            $compra = new Compra();
            $compra->set($fila);
            $compra->fields['titulo_libro'] = $fila['titulo_libro'];
            $compras[] = $compra;
        }

        return $compras;
    }
}