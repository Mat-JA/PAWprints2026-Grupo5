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
            'cache'       => false,
            'auto_escape' => 'html',
        ]);

        $twig->addGlobal('store', [
            'name'        => 'PAWPrints',
            'url'         => 'http://localhost:8080',
            'description' => 'Librería y espacio de lectura en Luján, Buenos Aires.',
            'telephone'   => '+54-000-0000000',
            'email'       => 'contacto@pawprints.com',
            'foundingDate'=> '2024',
            'address'     => [
                'street'   => 'Calle Ejemplo 1234',
                'locality' => 'Luján',
                'region'   => 'Buenos Aires',
                'postal'   => '6700',
                'country'  => 'AR',
            ],
            'hours' => 'Mo-Sa 09:00-20:00',
        ]);

        return $twig;
    }
}