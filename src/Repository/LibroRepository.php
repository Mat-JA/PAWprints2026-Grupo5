<?php

namespace App\Repository;

use PDO;
use App\Models\Libro;

class LibroRepository
{
    private const TABLE = 'libros';

    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerLibrosPaginados(int $pagina = 1, int $limite = 4, ?string $busqueda = null): array
    {
        $offset = ($pagina - 1) * $limite;

        if ($busqueda) {
            $sql = "SELECT * FROM " . self::TABLE . "
                    WHERE desc_corta ILIKE :busqueda
                    OR descripcion ILIKE :busqueda
                    OR isbn ILIKE :busqueda
                    ORDER BY id
                    LIMIT :limite OFFSET :offset";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
        } else {
            $sql = "SELECT * FROM " . self::TABLE . "
                    ORDER BY id
                    LIMIT :limite OFFSET :offset";

            $stmt = $this->conexion->prepare($sql);
        }

        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $libros = [];

        foreach ($filas as $fila) {
            $libro = new Libro();
            $libro->set($fila);
            $libros[] = $libro;
        }

        return $libros;
    }

    public function contarLibros(?string $busqueda = null): int
    {
        if ($busqueda) {
            $sql = "SELECT COUNT(*) FROM " . self::TABLE . "
                    WHERE desc_corta ILIKE :busqueda
                    OR descripcion ILIKE :busqueda
                    OR isbn ILIKE :busqueda";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindValue(':busqueda', '%' . $busqueda . '%');
        } else {
            $stmt = $this->conexion->prepare("SELECT COUNT(*) FROM " . self::TABLE);
        }

        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public function obtenerPorId(int $id): ?Libro{
        $sql = "SELECT * FROM " . self::TABLE . " WHERE id = :id LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fila) {
            return null;
        }

        $libro = new Libro();
        $libro->set($fila);

        return $libro;
    }
}
