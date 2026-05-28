<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class SecondBatchSeeder extends AbstractSeed
{
    public function run(): void
    {
        // IDs 5–18
        $autores = [
            ['nombre' => 'Mario Vargas Llosa',  'bio' => 'Escritor peruano, Premio Nobel de Literatura 2010.'],
            ['nombre' => 'Pablo Neruda',         'bio' => 'Poeta chileno, Premio Nobel de Literatura 1971.'],
            ['nombre' => 'Ernesto Sabato',       'bio' => 'Escritor y físico argentino, autor de El túnel y Sobre héroes y tumbas.'],
            ['nombre' => 'Roberto Bolaño',       'bio' => 'Escritor chileno, autor de 2666 y Los detectives salvajes.'],
            ['nombre' => 'Octavio Paz',          'bio' => 'Poeta y ensayista mexicano, Premio Nobel de Literatura 1990.'],
            ['nombre' => 'Juan Rulfo',           'bio' => 'Escritor mexicano, autor de Pedro Páramo.'],
            ['nombre' => 'Adolfo Bioy Casares',  'bio' => 'Escritor argentino, amigo y colaborador de Borges.'],
            ['nombre' => 'Manuel Puig',          'bio' => 'Escritor argentino, autor de El beso de la mujer araña.'],
            ['nombre' => 'Miguel de Cervantes',  'bio' => 'Escritor español del Siglo de Oro, autor del Quijote.'],
            ['nombre' => 'Franz Kafka',          'bio' => 'Escritor checo de lengua alemana, maestro del absurdo y la alienación.'],
            ['nombre' => 'Albert Camus',         'bio' => 'Escritor y filósofo francés, Premio Nobel de Literatura 1957.'],
            ['nombre' => 'Fiódor Dostoyevski',   'bio' => 'Novelista ruso del siglo XIX, autor de Crimen y castigo.'],
            ['nombre' => 'Lev Tolstói',          'bio' => 'Novelista ruso, autor de Guerra y paz y Anna Karenina.'],
            ['nombre' => 'José Hernández',       'bio' => 'Poeta argentino, autor del poema épico Martín Fierro.'],
        ];

        $this->table('autores')->insert($autores)->saveData();

        // IDs 7–31
        $libros = [
            [
                'titulo'      => 'La ciudad y los perros',
                'isbn'        => '978-84-322-1781-0',
                'desc_corta'  => 'Novela de iniciación en el Perú militar.',
                'descripcion' => 'Ambientada en el Colegio Militar Leoncio Prado de Lima, narra las tensiones y violencia entre cadetes adolescentes, primera novela del boom latinoamericano.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788432217810-L.jpg',
                'fecha_pub'   => '1963-10-01',
                'precio'      => 149.99,
                'stock'       => 10,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Conversación en La Catedral',
                'isbn'        => '978-84-322-1769-8',
                'desc_corta'  => 'Novela sobre la dictadura peruana de Odría.',
                'descripcion' => 'A través de una larga conversación en un bar limeño, Vargas Llosa retrata la corrupción y el fracaso moral del Perú bajo la dictadura de Odría.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788432217698-L.jpg',
                'fecha_pub'   => '1969-01-01',
                'precio'      => 165.00,
                'stock'       => 8,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Veinte poemas de amor y una canción desesperada',
                'isbn'        => '978-84-376-0082-4',
                'desc_corta'  => 'Poemario icónico de Pablo Neruda.',
                'descripcion' => 'Publicado en 1924, combina erotismo y melancolía del amor perdido. Uno de los libros de poesía más leídos en español.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788437600824-L.jpg',
                'fecha_pub'   => '1924-01-01',
                'precio'      => 90.00,
                'stock'       => 18,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'El túnel',
                'isbn'        => '978-84-322-0004-1',
                'desc_corta'  => 'Novela existencial de Ernesto Sabato.',
                'descripcion' => 'Un pintor obsesionado narra cómo asesinó a la única persona que entendió su obra. Meditación sobre la soledad y la incomunicación.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788432200041-L.jpg',
                'fecha_pub'   => '1948-01-01',
                'precio'      => 120.00,
                'stock'       => 14,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Sobre héroes y tumbas',
                'isbn'        => '978-950-07-0364-2',
                'desc_corta'  => 'Gran novela argentina de Sabato.',
                'descripcion' => 'Entrelaza el amor imposible entre Martín y Alejandra con la historia argentina, culminando en el enigmático "Informe sobre ciegos".',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9789500703642-L.jpg',
                'fecha_pub'   => '1961-01-01',
                'precio'      => 155.00,
                'stock'       => 9,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => '2666',
                'isbn'        => '978-84-339-7148-9',
                'desc_corta'  => 'Obra maestra póstuma de Roberto Bolaño.',
                'descripcion' => 'Novela en cinco partes que gira en torno a una ciudad fronteriza mexicana y los feminicidios en serie que la asolan, explorando el mal y la literatura.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788433971489-L.jpg',
                'fecha_pub'   => '2004-01-01',
                'precio'      => 180.00,
                'stock'       => 7,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Los detectives salvajes',
                'isbn'        => '978-84-339-6972-1',
                'desc_corta'  => 'Novela generacional de Bolaño.',
                'descripcion' => 'La búsqueda de una poeta desaparecida sirve de hilo conductor para retratar a toda una generación de poetas latinoamericanos en los años 70.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788433969721-L.jpg',
                'fecha_pub'   => '1998-01-01',
                'precio'      => 165.00,
                'stock'       => 11,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'El laberinto de la soledad',
                'isbn'        => '978-84-375-0482-8',
                'desc_corta'  => 'Ensayo fundamental sobre la identidad mexicana.',
                'descripcion' => 'Octavio Paz analiza la psicología e historia de México a través de mitos, máscaras y la herencia de la conquista.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788437504828-L.jpg',
                'fecha_pub'   => '1950-01-01',
                'precio'      => 110.00,
                'stock'       => 13,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Pedro Páramo',
                'isbn'        => '978-84-376-0436-5',
                'desc_corta'  => 'Novela fundacional del boom latinoamericano.',
                'descripcion' => 'Juan Preciado viaja al pueblo de Comala en busca de su padre y encuentra solo voces de muertos. Obra maestra de la narrativa latinoamericana.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788437604365-L.jpg',
                'fecha_pub'   => '1955-03-19',
                'precio'      => 115.00,
                'stock'       => 16,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'La invención de Morel',
                'isbn'        => '978-84-322-1793-3',
                'desc_corta'  => 'Novela fantástica de Bioy Casares.',
                'descripcion' => 'Un fugitivo llega a una isla desierta donde descubre una máquina capaz de proyectar personas como hologramas eternos. Preludio conceptual del realismo virtual.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788432217937-L.jpg',
                'fecha_pub'   => '1940-01-01',
                'precio'      => 105.00,
                'stock'       => 10,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'El beso de la mujer araña',
                'isbn'        => '978-84-322-0308-0',
                'desc_corta'  => 'Novela de Puig sobre cine, identidad y opresión.',
                'descripcion' => 'Dos prisioneros comparten una celda en Argentina: un militante político y un homosexual. Sus diálogos mediados por el cine exploran la identidad y la opresión.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788432203084-L.jpg',
                'fecha_pub'   => '1976-01-01',
                'precio'      => 130.00,
                'stock'       => 9,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Don Quijote de la Mancha',
                'isbn'        => '978-84-376-0241-5',
                'desc_corta'  => 'La primera novela moderna de la literatura occidental.',
                'descripcion' => 'Las aventuras del hidalgo Alonso Quijano, enloquecido por los libros de caballería, junto a su escudero Sancho Panza. Fundamento de la narrativa occidental.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788437602417-L.jpg',
                'fecha_pub'   => '1605-01-16',
                'precio'      => 200.00,
                'stock'       => 20,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'La metamorfosis',
                'isbn'        => '978-84-206-8994-9',
                'desc_corta'  => 'Relato kafkiano sobre la alienación.',
                'descripcion' => 'Gregor Samsa amanece convertido en un insecto gigante. Kafka retrata con precisión la frialdad familiar y la burocracia del mundo moderno.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420689944-L.jpg',
                'fecha_pub'   => '1915-10-15',
                'precio'      => 95.00,
                'stock'       => 22,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'El proceso',
                'isbn'        => '978-84-206-8761-7',
                'desc_corta'  => 'La burocracia como pesadilla existencial.',
                'descripcion' => 'Josef K. es arrestado sin que nadie le explique el motivo. Su intento por comprender y combatir un sistema judicial opaco se convierte en una trampa sin salida.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420687612-L.jpg',
                'fecha_pub'   => '1925-01-01',
                'precio'      => 110.00,
                'stock'       => 14,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'El extranjero',
                'isbn'        => '978-84-206-3344-7',
                'desc_corta'  => 'Novela del absurdo de Albert Camus.',
                'descripcion' => 'Meursault, indiferente al mundo, mata a un árabe en la playa de Argel y enfrenta un juicio que lo condena más por su frialdad que por el crimen.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420633442-L.jpg',
                'fecha_pub'   => '1942-05-19',
                'precio'      => 100.00,
                'stock'       => 19,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'La peste',
                'isbn'        => '978-84-206-3345-4',
                'desc_corta'  => 'Alegoría sobre la solidaridad humana.',
                'descripcion' => 'Una epidemia arrasa la ciudad de Orán. A través del doctor Rieux, Camus reflexiona sobre la solidaridad, la resistencia y el absurdo de la condición humana.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420633459-L.jpg',
                'fecha_pub'   => '1947-06-10',
                'precio'      => 105.00,
                'stock'       => 15,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Crimen y castigo',
                'isbn'        => '978-84-206-3190-0',
                'desc_corta'  => 'Psicología del crimen según Dostoyevski.',
                'descripcion' => 'Raskolnikov asesina a una usurera creyéndose por encima de la moral. Su descenso psicológico posterior es uno de los retratos más profundos de la culpa en la literatura.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420631905-L.jpg',
                'fecha_pub'   => '1866-01-01',
                'precio'      => 140.00,
                'stock'       => 13,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'El idiota',
                'isbn'        => '978-84-206-3191-7',
                'desc_corta'  => 'El hombre bueno en una sociedad corrupta.',
                'descripcion' => 'El príncipe Myshkin, bondadoso y epiléptico, regresa a la sociedad rusa y choca con la hipocresía, la ambición y la pasión destructiva de quienes lo rodean.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420631912-L.jpg',
                'fecha_pub'   => '1869-01-01',
                'precio'      => 145.00,
                'stock'       => 10,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Anna Karenina',
                'isbn'        => '978-84-206-3477-2',
                'desc_corta'  => 'Tragedia del amor y la sociedad rusa zarista.',
                'descripcion' => 'Anna abandona a su marido por el conde Vronsky. Tolstói construye un fresco monumental de la sociedad rusa y explora la moralidad, la familia y la libertad.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420634777-L.jpg',
                'fecha_pub'   => '1877-01-01',
                'precio'      => 170.00,
                'stock'       => 12,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Guerra y paz',
                'isbn'        => '978-84-376-0293-4',
                'desc_corta'  => 'Épica de la invasión napoleónica a Rusia.',
                'descripcion' => 'A través de varias familias rusas durante las guerras napoleónicas, Tolstói construye una de las novelas más ambiciosas de la literatura universal.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788437602936-L.jpg',
                'fecha_pub'   => '1869-01-01',
                'precio'      => 190.00,
                'stock'       => 8,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Bestiario',
                'isbn'        => '978-84-204-7043-5',
                'desc_corta'  => 'Primer libro de cuentos de Cortázar.',
                'descripcion' => 'Ocho cuentos donde lo fantástico irrumpe en lo cotidiano: casas tomadas, tigres que conviven con familias, perturbaciones sin explicación racional.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420470435-L.jpg',
                'fecha_pub'   => '1951-01-01',
                'precio'      => 115.00,
                'stock'       => 11,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'El amor en los tiempos del cólera',
                'isbn'        => '978-84-397-0508-5',
                'desc_corta'  => 'Historia de amor que espera cincuenta años.',
                'descripcion' => 'Florentino Ariza espera más de cincuenta años para declarar su amor a Fermina Daza. García Márquez explora el amor obsesivo, el paso del tiempo y la vejez.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788439705086-L.jpg',
                'fecha_pub'   => '1985-01-01',
                'precio'      => 155.00,
                'stock'       => 14,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'El otoño del patriarca',
                'isbn'        => '978-84-397-0172-8',
                'desc_corta'  => 'Retrato del poder absoluto y la soledad.',
                'descripcion' => 'La muerte de un dictador caribeño de edad incierta desencadena el relato circular de su poder absoluto, su soledad y la corrupción que lo rodea.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788439701729-L.jpg',
                'fecha_pub'   => '1975-03-01',
                'precio'      => 145.00,
                'stock'       => 9,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Martín Fierro',
                'isbn'        => '978-84-376-0296-5',
                'desc_corta'  => 'Poema épico gauchesco, obra fundacional argentina.',
                'descripcion' => 'El gaucho Martín Fierro narra su vida en la pampa, su reclutamiento forzoso y la injusticia del Estado. Obra fundacional de la identidad cultural argentina.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788437602966-L.jpg',
                'fecha_pub'   => '1872-11-28',
                'precio'      => 85.00,
                'stock'       => 25,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'titulo'      => 'Las armas secretas',
                'isbn'        => '978-84-204-8143-1',
                'desc_corta'  => 'Colección de cuentos de Cortázar.',
                'descripcion' => 'Incluye "El perseguidor", inspirado en Charlie Parker, uno de los relatos más celebrados de Cortázar sobre el arte, el tiempo y la autodestrucción.',
                'imagen_url'  => 'https://covers.openlibrary.org/b/isbn/9788420481432-L.jpg',
                'fecha_pub'   => '1959-01-01',
                'precio'      => 120.00,
                'stock'       => 12,
                'created_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->table('libros')->insert($libros)->saveData();

        $autorLibro = [
            // Nuevos autores con nuevos libros
            ['autor_id' => 5,  'libro_id' => 7],  // Vargas Llosa  -> La ciudad y los perros
            ['autor_id' => 5,  'libro_id' => 8],  // Vargas Llosa  -> Conversación en La Catedral
            ['autor_id' => 6,  'libro_id' => 9],  // Neruda        -> Veinte poemas de amor
            ['autor_id' => 7,  'libro_id' => 10], // Sabato        -> El túnel
            ['autor_id' => 7,  'libro_id' => 11], // Sabato        -> Sobre héroes y tumbas
            ['autor_id' => 8,  'libro_id' => 12], // Bolaño        -> 2666
            ['autor_id' => 8,  'libro_id' => 13], // Bolaño        -> Los detectives salvajes
            ['autor_id' => 9,  'libro_id' => 14], // Paz           -> El laberinto de la soledad
            ['autor_id' => 10, 'libro_id' => 15], // Rulfo         -> Pedro Páramo
            ['autor_id' => 11, 'libro_id' => 16], // Bioy Casares  -> La invención de Morel
            ['autor_id' => 12, 'libro_id' => 17], // Puig          -> El beso de la mujer araña
            ['autor_id' => 13, 'libro_id' => 18], // Cervantes     -> Don Quijote
            ['autor_id' => 14, 'libro_id' => 19], // Kafka         -> La metamorfosis
            ['autor_id' => 14, 'libro_id' => 20], // Kafka         -> El proceso
            ['autor_id' => 15, 'libro_id' => 21], // Camus         -> El extranjero
            ['autor_id' => 15, 'libro_id' => 22], // Camus         -> La peste
            ['autor_id' => 16, 'libro_id' => 23], // Dostoyevski   -> Crimen y castigo
            ['autor_id' => 16, 'libro_id' => 24], // Dostoyevski   -> El idiota
            ['autor_id' => 17, 'libro_id' => 25], // Tolstói       -> Anna Karenina
            ['autor_id' => 17, 'libro_id' => 26], // Tolstói       -> Guerra y paz
            ['autor_id' => 18, 'libro_id' => 30], // Hernández     -> Martín Fierro
            // Autores existentes con libros nuevos
            ['autor_id' => 3,  'libro_id' => 27], // Cortázar      -> Bestiario
            ['autor_id' => 2,  'libro_id' => 28], // García Márquez-> El amor en los tiempos del cólera
            ['autor_id' => 2,  'libro_id' => 29], // García Márquez-> El otoño del patriarca
            ['autor_id' => 3,  'libro_id' => 31], // Cortázar      -> Las armas secretas
        ];

        $this->table('autor_libro')->insert($autorLibro)->saveData();
    }
}
