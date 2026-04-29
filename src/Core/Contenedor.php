<?php

namespace App\Core;

class Contenedor
{
    private array $servicios = [];

    public function set(string $nombre, $valor): void
    {
        $this->servicios[$nombre] = $valor;
    }

    public function get(string $nombre)
    {
        return $this->servicios[$nombre] ?? null;
    }
}