<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class FirstTablesSeeder extends AbstractSeed
{
    public function run(): void
    {
        $autores = [
            ['nombre' => 'Jorge Luis Borges',   'bio' => 'Escritor argentino, autor de Ficciones y El Aleph.'],
            ['nombre' => 'Gabriel García Márquez', 'bio' => 'Escritor colombiano, Premio Nobel de Literatura 1982.'],
            ['nombre' => 'Julio Cortázar',       'bio' => 'Escritor argentino, referente del realismo mágico latinoamericano.'],
            ['nombre' => 'Isabel Allende',        'bio' => 'Escritora chilena, autora de La casa de los espíritus.'],
        ];

        $this->table('autores')->insert($autores)->saveData();

        $libros = [
            [
                'titulo'     => 'Ficciones',
                'isbn'       => '978-8-4206-5089-2',
                'desc_corta' => 'Colección de cuentos de Borges.',
                'descripcion'=> 'Una de las obras más influyentes de la literatura universal, reúne cuentos que exploran laberintos, espejos y mundos imaginarios.',
                'imagen_url' => 'https://http2.mlstatic.com/D_NQ_NP_727486-MLU75135944095_032024-O.webp',
                'fecha_pub'  => '1944-01-01',
                'precio' => 100.00,
                'stock'      => 15,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'     => 'El Aleph',
                'isbn'       => '978-8-4206-5090-8',
                'desc_corta' => 'Cuentos fantásticos de Borges.',
                'descripcion'=> 'Colección de cuentos donde Borges explora el infinito, el tiempo y la identidad.',
                'imagen_url' => 'https://acdn-us.mitiendanube.com/stores/004/088/117/products/526276-89085513a3228322a417401963950459-1024-1024.webp',
                'fecha_pub'  => '1949-01-01',
                'precio' => 150.99,
                'stock'      => 10,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'     => 'Cien años de soledad',
                'isbn'       => '978-8-4972-3374-4',
                'desc_corta' => 'La saga de la familia Buendía.',
                'descripcion'=> 'La historia de la familia Buendía a lo largo de siete generaciones en el pueblo ficticio de Macondo.',
                'imagen_url' => 'https://images.cdn3.buscalibre.com/fit-in/360x360/61/8d/618d227e8967274cd9589a549adff52d.jpg',
                'fecha_pub'  => '1967-05-30',
                'precio' => 160.99,
                'stock'      => 20,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'     => 'Rayuela',
                'isbn'       => '978-8-4663-1247-6',
                'desc_corta' => 'Novela experimental de Cortázar.',
                'descripcion'=> 'Una novela que puede leerse en múltiple órdenes, explorando la búsqueda existencial de su protagonista Horacio Oliveira.',
                'imagen_url' => 'https://www.penguinlibros.com/ar/7130737-large_default/rayuela-edicion-conmemorativa.webp',
                'fecha_pub'  => '1963-06-28',
                'precio' => 159.99,
                'stock'      => 12,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'     => 'La casa de los espíritus',
                'isbn'       => '978-8-4018-5765-1',
                'desc_corta' => 'Saga familiar de Isabel Allende.',
                'descripcion'=> 'La historia de la familia Trueba a través de varias generaciones, mezclando lo político con lo mágico.',
                'imagen_url' => 'https://www.penguinlibros.com/ar/2103926/la-casa-de-los-espiritus.jpg',
                'fecha_pub'  => '1982-01-01',
                'precio' => 150.99,
                'stock'      => 8,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('libros')->insert($libros)->saveData();

        // autor_id y libro_id según el orden de inserción (IDs 1 al 4 para autores, 1 al 5 para libros)
        $autorLibro = [
            ['autor_id' => 1, 'libro_id' => 1], // Borges -> Ficciones
            ['autor_id' => 1, 'libro_id' => 2], // Borges -> El Aleph
            ['autor_id' => 2, 'libro_id' => 3], // García Márquez -> Cien años de soledad
            ['autor_id' => 3, 'libro_id' => 4], // Cortázar -> Rayuela
            ['autor_id' => 4, 'libro_id' => 5], // Allende -> La casa de los espíritus
        ];

        $this->table('autor_libro')->insert($autorLibro)->saveData();
    }
}
