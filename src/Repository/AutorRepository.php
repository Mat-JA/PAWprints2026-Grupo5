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
