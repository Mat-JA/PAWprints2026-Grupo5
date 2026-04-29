<?php

namespace App\Models;

use App\Core\AbstractModel;
use App\Core\Exceptions\InvalidValueFormatException;

class Libro extends AbstractModel
{
    public string $table = 'libro';

    public array $fields = [
        'id' => null,
        'isbn' => null,
        'descripcion_corta' => null,
        'descripcion_completa' => null,
        'precio' => null,
        'imagen_url' => null,
        'fecha_publicacion' => null,
        'stock' => null,
        'created_at' => null,
    ];

    public function setId(int $id)
    {
        if ($id <= 0) {
            throw new InvalidValueFormatException('El ID debe ser mayor a cero');
        }

        $this->fields['id'] = $id;
    }

    public function setIsbn(string $isbn)
    {
        if (strlen($isbn) > 20) {
            throw new InvalidValueFormatException('ISBN demasiado largo');
        }

        $this->fields['isbn'] = $isbn;
    }

    public function setDescripcion_corta(string $descripcion)
    {
        if (strlen($descripcion) > 255) {
            throw new InvalidValueFormatException('La descripción corta no debe superar 255 caracteres');
        }

        $this->fields['descripcion_corta'] = $descripcion;
    }

    public function setDescripcion_completa(string $descripcion)
    {
        $this->fields['descripcion_completa'] = $descripcion;
    }

    public function setPrecio(float $precio)
    {
        if ($precio < 0) {
            throw new InvalidValueFormatException('El precio no puede ser negativo');
        }

        $this->fields['precio'] = $precio;
    }

    public function setImagen_url(string $imagen)
    {
        $this->fields['imagen_url'] = $imagen;
    }

    public function setFecha_publicacion(string $fecha)
    {
        $this->fields['fecha_publicacion'] = $fecha;
    }

    public function setStock(int $stock)
    {
        if ($stock < 0) {
            throw new InvalidValueFormatException('El stock no puede ser negativo');
        }

        $this->fields['stock'] = $stock;
    }

    public function setCreated_at(string $createdAt)
    {
        $this->fields['created_at'] = $createdAt;
    }

    public function set(array $values)
    {
        foreach (array_keys($this->fields) as $field) {
            if (!isset($values[$field])) {
                continue;
            }

            $method = 'set' . ucfirst($field);

            if (method_exists($this, $method)) {
                $this->$method($values[$field]);
            }
        }
    }
}