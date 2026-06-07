<?php

namespace App\Repository;

use PDO;
use App\Models\Autor;

class AutorRepository
{
    private const TABLE = 'autores';
    private const JOIN_TABLE = 'autor_libro';
    private const BOOK_TABLE = 'libros';

    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    /**
     * Obtiene un autor por su ID.
     *
     * @param int $id
     * @return Autor|null
     */
    public function obtenerPorId(int $id): ?Autor
    {
        $sql = "SELECT * FROM " . self::TABLE . " WHERE id = :id LIMIT 1";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$fila) return null;

        $autor = new Autor();
        $autor->set($fila);
        return $autor;
    }

    /**
     * Obtiene todos los autores registrados en la base de datos.
     *
     * @return Autor[]
     */
    public function obtenerTodos(): array
    {
        $sql = "SELECT * FROM " . self::TABLE . " ORDER BY nombre";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $autores = [];
        foreach ($filas as $fila) {
            $autor = new Autor();
            $autor->set($fila);
            $autores[] = $autor;
        }

        return $autores;
    }

    /**
     * Vincula un autor a un libro en la tabla intermedia.
     */
    public function vincularAutor(int $libroId, int $autorId): bool
    {
        $sql = "INSERT INTO " . self::JOIN_TABLE . " (autor_id, libro_id) VALUES (:autor_id, :libro_id)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':autor_id', $autorId, PDO::PARAM_INT);
        $stmt->bindValue(':libro_id', $libroId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Crea un nuevo autor.
     */
    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO " . self::TABLE . " (nombre, bio) VALUES (:nombre, :bio)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':nombre', $datos['nombre']);
        $stmt->bindValue(':bio',    $datos['bio'] ?? '');
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Actualiza un autor existente.
     */
    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE " . self::TABLE . " SET nombre = :nombre, bio = :bio WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':nombre', $datos['nombre']);
        $stmt->bindValue(':bio',    $datos['bio'] ?? '');
        $stmt->bindValue(':id',     $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Elimina un autor.
     */
    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM " . self::TABLE . " WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Obtiene el último ID insertado.
     */
    public function obtenerUltimoId(): int
    {
        return (int) $this->conexion->lastInsertId();
    }

    /**
     * Desvincula todos los autores de un libro.
     */
    public function desvincularAutores(int $libroId): bool
    {
        $sql = "DELETE FROM " . self::JOIN_TABLE . " WHERE libro_id = :libro_id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':libro_id', $libroId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount() >= 0;
    }

    /**
     * Obtiene todos los autores de un libro dado su ID.
     *
     * Si el libro no existe en la base de datos, devuelve un array vacío.
     *
     * @param int $libroId
     * @return Autor[]
     */
    public function obtenerAutoresPorLibroId(int $libroId): array
    {
        // Verificar que el libro existe
        $sqlCheck = "SELECT COUNT(*) FROM " . self::BOOK_TABLE . " WHERE id = :id";
        $stmtCheck = $this->conexion->prepare($sqlCheck);
        $stmtCheck->bindValue(':id', $libroId, PDO::PARAM_INT);
        $stmtCheck->execute();

        if ((int) $stmtCheck->fetchColumn() === 0) {
            return [];
        }

        // Obtener los autores del libro
        $sql = "SELECT a.id, a.nombre, a.bio
                FROM " . self::TABLE . " a
                INNER JOIN " . self::JOIN_TABLE . " al ON a.id = al.autor_id
                WHERE al.libro_id = :libro_id";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindValue(':libro_id', $libroId, PDO::PARAM_INT);
        $stmt->execute();

        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $autores = [];
        foreach ($filas as $fila) {
            $autor = new Autor();
            $autor->set($fila);
            $autores[] = $autor;
        }

        return $autores;
    }
}
