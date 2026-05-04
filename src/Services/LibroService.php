<?php

namespace App\Services;

use App\Repository\LibroRepository;

class LibroService
{
    public LibroRepository $libroRepository;

    public function __construct(LibroRepository $libroRepository)
    {
        $this->libroRepository = $libroRepository;
    }
}
