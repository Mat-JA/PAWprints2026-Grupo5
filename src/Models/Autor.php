<?php

namespace App\Models;

use App\Core\AbstractModel;
use App\Core\Exceptions\InvalidValueFormatException;

class Autor extends AbstractModel
{
    public string $table = 'autores';

    public array $fields = [
        'id' => null,
        'nombre' => null,
        'bio' => null,
    ];

    public function setId(int $id)
    {
        if ($id <= 0) {
            throw new InvalidValueFormatException('El ID debe ser mayor a cero');
        }

        $this->fields['id'] = $id;
    }

    public function setNombre(string $nombre)
    {
        if (strlen($nombre) > 60) {
            throw new InvalidValueFormatException('El nombre del autor no debe ser mayor a 60 caracteres');
        }

        $this->fields['nombre'] = $nombre;
    }

    public function setBio(string $bio)
    {
        if (strlen($bio) > 250) {
            throw new InvalidValueFormatException('La biografía del autor no debe ser mayor a 250 caracteres');
        }

        $this->fields['bio'] = $bio;
    }

    public function set(array $values)
    {
        foreach (array_keys($this->fields) as $field) {
            if (!isset($values[$field])) {
                continue;
            }

            $method = 'set' . ucfirst($field);

            $this->$method($values[$field]);
        }
    }
}
