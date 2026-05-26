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

    public function decrementarStock(int $id): bool
    {
        $sql = "UPDATE " . self::TABLE . " SET stock = stock - 1 WHERE id = :id AND stock > 0";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function obtenerTodos(): array
    {
        $sql = "SELECT * FROM " . self::TABLE . " ORDER BY id";
        $stmt = $this->conexion->prepare($sql);
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

    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO " . self::TABLE . "
                (titulo, isbn, desc_corta, descripcion, imagen_url, fecha_pub, precio, stock, created_at)
                VALUES (:titulo, :isbn, :desc_corta, :descripcion, :imagen_url, :fecha_pub, :precio, :stock, NOW())";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':titulo',      $datos['titulo']);
        $stmt->bindValue(':isbn',        $datos['isbn']);
        $stmt->bindValue(':desc_corta',  $datos['desc_corta']);
        $stmt->bindValue(':descripcion', $datos['descripcion']);
        $stmt->bindValue(':imagen_url',  $datos['imagen_url']);
        $stmt->bindValue(':fecha_pub',   $datos['fecha_pub']);
        $stmt->bindValue(':precio',      $datos['precio']);
        $stmt->bindValue(':stock',       $datos['stock'], PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE " . self::TABLE . " SET
                titulo      = :titulo,
                isbn        = :isbn,
                desc_corta  = :desc_corta,
                descripcion = :descripcion,
                imagen_url  = :imagen_url,
                fecha_pub   = :fecha_pub,
                precio      = :precio,
                stock       = :stock
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':titulo',      $datos['titulo']);
        $stmt->bindValue(':isbn',        $datos['isbn']);
        $stmt->bindValue(':desc_corta',  $datos['desc_corta']);
        $stmt->bindValue(':descripcion', $datos['descripcion']);
        $stmt->bindValue(':imagen_url',  $datos['imagen_url']);
        $stmt->bindValue(':fecha_pub',   $datos['fecha_pub']);
        $stmt->bindValue(':precio',      $datos['precio']);
        $stmt->bindValue(':stock',       $datos['stock'], PDO::PARAM_INT);
        $stmt->bindValue(':id',          $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function actualizarImagenUrl(int $id, string $imagenUrl): bool
    {
        $sql = "UPDATE " . self::TABLE . " SET imagen_url = :imagen_url WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':imagen_url', $imagenUrl);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
    
}
