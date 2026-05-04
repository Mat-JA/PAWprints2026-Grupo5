<?php

namespace App\Models;

use App\Core\AbstractModel;
use App\Core\Exceptions\InvalidValueFormatException;

class Libro extends AbstractModel
{
    public string $table = 'libros';

    public array $fields = [
        'id' => null,
        'titulo' => null,
        'isbn' => null,
        'desc_corta' => null,
        'descripcion' => null,
        'imagen_url' => null,
        'fecha_pub' => null,
        'precio' => null,
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

    public function setTitulo(string $titulo)
    {
        $this->fields['titulo'] = $titulo;
    }

    public function setIsbn(string $isbn)
    {
        if (strlen($isbn) > 20) {
            throw new InvalidValueFormatException('ISBN demasiado largo');
        }

        $this->fields['isbn'] = $isbn;
    }

    public function setDesc_corta(string $descripcion)
    {
        if (strlen($descripcion) > 255) {
            throw new InvalidValueFormatException('La descripción corta no debe superar 255 caracteres');
        }

        $this->fields['desc_corta'] = $descripcion;
    }

    public function setDescripcion(string $descripcion)
    {
        $this->fields['descripcion'] = $descripcion;
    }

    public function setImagen_url(string $imagen)
    {
        $this->fields['imagen_url'] = $imagen;
    }

    public function setFecha_pub(string $fecha)
    {
        $this->fields['fecha_pub'] = $fecha;
    }

    public function setStock(int $stock)
    {
        if ($stock < 0) {
            throw new InvalidValueFormatException('El stock no puede ser negativo');
        }

        $this->fields['stock'] = $stock;
    }

    public function setPrecio(float $precio)
    {
        if ($precio < 0.0) {
            throw new InvalidValueFormatException('El stock no puede ser negativo');
        }

        $this->fields['precio'] = $precio;
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
