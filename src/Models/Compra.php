<?php

namespace App\Models;

use App\Core\AbstractModel;
use App\Core\Exceptions\InvalidValueFormatException;

class Compra extends AbstractModel
{
    public string $table = 'compras';

    public array $fields = [
        'id'        => null,
        'id_libro'  => null,
        'nombre'    => null,
        'apellido'  => null,
        'email'     => null,
        'pais'      => null,
        'provincia' => null,
        'ciudad'    => null,
        'calle'     => null,
        'nro_calle' => null,
    ];

    public function setId(int $id): void
    {
        if ($id <= 0) {
            throw new InvalidValueFormatException('El ID debe ser mayor a cero');
        }
        $this->fields['id'] = $id;
    }

    public function setId_libro(int $id_libro): void
    {
        if ($id_libro <= 0) {
            throw new InvalidValueFormatException('El ID de libro debe ser mayor a cero');
        }
        $this->fields['id_libro'] = $id_libro;
    }

    public function setNombre(string $nombre): void
    {
        if (strlen($nombre) < 2 || strlen($nombre) > 15) {
            throw new InvalidValueFormatException('El nombre debe tener entre 2 y 15 caracteres');
        }
        $this->fields['nombre'] = $nombre;
    }

    public function setApellido(string $apellido): void
    {
        if (strlen($apellido) < 2 || strlen($apellido) > 25) {
            throw new InvalidValueFormatException('El apellido debe tener entre 2 y 25 caracteres');
        }
        $this->fields['apellido'] = $apellido;
    }

    public function setEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidValueFormatException('El email no es válido');
        }
        $this->fields['email'] = $email;
    }

    public function setPais(string $pais): void
    {
        $this->fields['pais'] = $pais;
    }

    public function setProvincia(string $provincia): void
    {
        $this->fields['provincia'] = $provincia;
    }

    public function setCiudad(string $ciudad): void
    {
        $this->fields['ciudad'] = $ciudad;
    }

    public function setCalle(string $calle): void
    {
        $this->fields['calle'] = $calle;
    }

    public function setNro_calle(int $nro_calle): void
    {
        if ($nro_calle < 0) {
            throw new InvalidValueFormatException('El número de calle no puede ser negativo');
        }
        $this->fields['nro_calle'] = $nro_calle;
    }

    public function set(array $values): void
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