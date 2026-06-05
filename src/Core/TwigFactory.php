<?php

namespace App\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigFactory
{
    public static function create(): Environment
    {
        $loader = new FilesystemLoader(__DIR__ . '/../../views');

        $twig = new Environment($loader, [
            'cache' => false, // cambiar a __DIR__ . '/../../storage/cache/twig' en producción
            'auto_escape' => 'html',
        ]);

        return $twig;
    }
}