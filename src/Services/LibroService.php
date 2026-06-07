<?php

namespace App\Services;

use App\Repository\AutorRepository;
use App\Repository\LibroRepository;
use App\Models\Libro;

class LibroService
{
    private LibroRepository $libroRepository;
    private AutorRepository $autorRepository;

    public function __construct(
        LibroRepository $libroRepository,
        AutorRepository $autorRepository,
    ) {
        $this->libroRepository = $libroRepository;
        $this->autorRepository = $autorRepository;
    }

    public function obtenerPaginado(int $pagina, int $limite, ?string $busqueda): array
    {
        $totalLibros = $this->libroRepository->contarLibros($busqueda);
        $totalPaginas = (int) ceil($totalLibros / $limite);
        $libros = $this->libroRepository->obtenerLibrosPaginados($pagina, $limite, $busqueda);
        return [
            'libros' => $libros,
            'totalPaginas' => $totalPaginas,
            'totalLibros' => $totalLibros,
        ];
    }

    public function obtenerPorId(int $id): ?Libro
    {
        return $this->libroRepository->obtenerPorId($id);
    }

    public function obtenerTodosParaCsv(): array
    {
        return $this->libroRepository->obtenerLibrosPaginados(1, 1000, null);
    }

    public function obtenerTodos(): array
    {
        return $this->libroRepository->obtenerTodos();
    }

    /**
     * Obtiene todos los libros con sus autores.
     *
     * Devuelve un array donde cada elemento tiene los campos del libro
     * más un campo 'autores' con el id y nombre de cada autor.
     *
     * @return array
     */
    public function obtenerTodosConAutor(): array
    {
        $libros = $this->libroRepository->obtenerTodos();

        $resultado = [];

        foreach ($libros as $libro) {
            $datosLibro = $libro->fields;

            $autoresModel = $this->autorRepository->obtenerAutoresPorLibroId(
                (int) $datosLibro['id']
            );

            $autores = [];
            foreach ($autoresModel as $autor) {
                $autores[] = [
                    'id' => $autor->fields['id'],
                    'nombre' => $autor->fields['nombre'],
                ];
            }

            $datosLibro['autores'] = $autores;
            $resultado[] = $datosLibro;
        }

        return $resultado;
    }

    /**
     * Obtiene un libro por ID con sus autores.
     *
     * Devuelve los campos del libro más un campo 'autores' con el id y nombre
     * de cada autor. Retorna null si el libro no existe.
     *
     * @param int $id
     * @return array|null
     */
    public function obtenerPorIdConAutores(int $id): ?array
    {
        $libro = $this->libroRepository->obtenerPorId($id);

        if (!$libro) {
            return null;
        }

        $datosLibro = $libro->fields;

        $autoresModel = $this->autorRepository->obtenerAutoresPorLibroId($id);

        $autores = [];
        foreach ($autoresModel as $autor) {
            $autores[] = [
                'id' => $autor->fields['id'],
                'nombre' => $autor->fields['nombre'],
            ];
        }

        $datosLibro['autores'] = $autores;

        return $datosLibro;
    }

    public function crear(array $datos, ?array $archivo): bool
    {
        $datos['imagen_url'] = $this->_procesarImagen(null, $archivo, $datos['isbn'] ?? '');
        $resultado = $this->libroRepository->crear($datos);

        if ($resultado && !empty($datos['autor_id'])) {
            $libroId = $this->libroRepository->obtenerUltimoId();
            $this->autorRepository->vincularAutor($libroId, (int) $datos['autor_id']);
        }

        return $resultado;
    }

    public function actualizar(int $id, array $datos, ?array $archivo): bool
    {
        $libro = $this->libroRepository->obtenerPorId($id);
        if (!$libro) {
            throw new \InvalidArgumentException("El libro con id {$id} no existe.");
        }

        // Si no se subió imagen nueva, mantener la existente o buscar en OL
        $datos['imagen_url'] = $this->_procesarImagen($libro->fields['imagen_url'], $archivo, $datos['isbn'] ?? '');

        $resultado = $this->libroRepository->actualizar($id, $datos);

        if ($resultado && !empty($datos['autor_id'])) {
            $this->autorRepository->desvincularAutores($id);
            $this->autorRepository->vincularAutor($id, (int) $datos['autor_id']);
        }

        return $resultado;
    }

    public function eliminar(int $id): bool
    {
        $libro = $this->libroRepository->obtenerPorId($id);
        if (!$libro) {
            throw new \InvalidArgumentException("El libro con id {$id} no existe.");
        }
        return $this->libroRepository->eliminar($id);
    }

    /**
     * Busca información de un libro en Open Library por ISBN.
     *
     * @return array con title, author_name, publish_date, description, cover_url, isbn
     *               o ['error' => '...'] si no se encontró.
     */
    public function buscarEnOpenLibrary(string $isbn): array
    {
        $isbnClean = preg_replace('/[^0-9Xx]/', '', $isbn);

        if (strlen($isbnClean) !== 10 && strlen($isbnClean) !== 13) {
            return ['error' => 'El ISBN debe tener 10 o 13 dígitos.'];
        }

        $data = $this->_fetchOpenLibrary("https://openlibrary.org/isbn/{$isbnClean}.json");
        if (!$data || isset($data['error'])) {
            // Fallback: buscar por query, preferir español
            $searchData = $this->_fetchOpenLibrary("https://openlibrary.org/search.json?q=" . urlencode($isbnClean) . "&language=spa&limit=1");
            if (empty($searchData['docs'][0])) {
                $searchData = $this->_fetchOpenLibrary("https://openlibrary.org/search.json?q=" . urlencode($isbnClean) . "&limit=1");
            }
            if (!empty($searchData['docs'][0])) {
                $data = $searchData['docs'][0];
            }
        }

        if (!$data) {
            return ['error' => 'No se encontró información para ese ISBN.'];
        }

        return $this->_extraerDatosLibro($data, $isbnClean);
    }

    /**
     * Busca información de un libro en Open Library por título.
     *
     * @return array con title, author_name, publish_date, description, cover_url, isbn
     *               o ['error' => '...'] si no se encontró.
     */
    public function buscarPorTituloEnOpenLibrary(string $titulo): array
    {
        $titulo = trim($titulo);
        if (strlen($titulo) < 2) {
            return ['error' => 'El título debe tener al menos 2 caracteres.'];
        }

        // Preferir resultados en español
        $searchData = $this->_fetchOpenLibrary(
            "https://openlibrary.org/search.json?q=" . urlencode($titulo) . "&language=spa&limit=1&fields=title,author_name,publish_date,isbn,cover_i,subject,first_sentence"
        );
        if (empty($searchData['docs'][0])) {
            // Fallback sin filtro de idioma
            $searchData = $this->_fetchOpenLibrary(
                "https://openlibrary.org/search.json?q=" . urlencode($titulo) . "&limit=1&fields=title,author_name,publish_date,isbn,cover_i,subject,first_sentence"
            );
        }

        if (empty($searchData['docs'][0])) {
            return ['error' => 'No se encontraron resultados para ese título.'];
        }

        $data = $searchData['docs'][0];
        $isbn = $data['isbn'][0] ?? '';

        return $this->_extraerDatosLibro($data, $isbn);
    }

    /**
     * Extrae campos normalizados de la respuesta de Open Library.
     */
    private function _extraerDatosLibro(array $data, string $isbnFallback = ''): array
    {
        $resultado = [
            'title'        => $data['title'] ?? $data['full_title'] ?? '',
            'publish_date' => '',
            'isbn'         => $data['isbn'][0] ?? (is_string($data['isbn'] ?? null) ? $data['isbn'] : $isbnFallback),
        ];

        if (!empty($data['publish_date'])) {
            $fechas = is_array($data['publish_date']) ? $data['publish_date'] : [$data['publish_date']];
            foreach ($fechas as $f) {
                $normalizada = $this->_normalizarFecha($f);
                if ($normalizada) {
                    $resultado['publish_date'] = $normalizada;
                    break;
                }
            }
        }

        // Descripción
        $descripcion = $data['description'] ?? $data['subtitle'] ?? $data['first_sentence'] ?? '';
        if (is_array($descripcion)) $descripcion = implode(' ', $descripcion);
        if (!$descripcion && !empty($data['subjects'])) {
            $descripcion = implode('. ', array_slice($data['subjects'], 0, 3));
        }
        if (!$descripcion && !empty($data['subject'])) {
            $subjects = is_array($data['subject']) ? $data['subject'] : [$data['subject']];
            $descripcion = implode('. ', array_slice($subjects, 0, 3));
        }
        $resultado['description'] = $descripcion;

        // Autores
        $autorNombres = $data['author_name'] ?? [];
        if (is_string($autorNombres)) $autorNombres = [$autorNombres];
        if (empty($autorNombres) && !empty($data['authors'])) {
            foreach ($data['authors'] as $autor) {
                $autorKey = $autor['key'] ?? '';
                if ($autorKey) {
                    $autorData = $this->_fetchOpenLibrary("https://openlibrary.org{$autorKey}.json");
                    if (!empty($autorData['name'])) {
                        $autorNombres[] = $autorData['name'];
                    }
                }
            }
        }
        $resultado['author_name'] = implode(', ', $autorNombres);

        // Tapa
        if (!empty($data['covers'][0])) {
            $resultado['cover_url'] = "https://covers.openlibrary.org/b/id/{$data['covers'][0]}-L.jpg";
        } elseif (!empty($data['cover_i'])) {
            $resultado['cover_url'] = "https://covers.openlibrary.org/b/id/{$data['cover_i']}-L.jpg";
        } elseif (!empty($resultado['isbn'])) {
            $resultado['cover_url'] = "https://covers.openlibrary.org/b/isbn/{$resultado['isbn']}-L.jpg";
        }

        return $resultado;
    }

    /**
     * Descarga una tapa desde Open Library por ISBN.
     * Prueba primero la URL por ISBN, y si falla consulta la API de edición
     * para obtener el cover ID y probar con ese.
     */
    public function descargarTapaOpenLibrary(string $isbn): string
    {
        $isbnSrc = preg_replace('/[^0-9Xx]/', '', $isbn);

        // Intentar por ISBN primero
        $urls = ["https://covers.openlibrary.org/b/isbn/{$isbnSrc}-L.jpg"];

        // Si falla, buscar el cover_id desde la API de edición
        $editionData = $this->_fetchOpenLibrary("https://openlibrary.org/isbn/{$isbnSrc}.json");
        if (!empty($editionData['covers'][0])) {
            $urls[] = "https://covers.openlibrary.org/b/id/{$editionData['covers'][0]}-L.jpg";
        }

        $imagenData = false;
        foreach ($urls as $url) {
            $data = @file_get_contents($url, false, stream_context_create([
                'http' => [
                    'timeout' => 10,
                    'user_agent' => 'PAWPrints/1.0',
                ],
            ]));

            if ($data !== false && strlen($data) > 2000) {
                $info = @getimagesizefromstring($data);
                if ($info && $info[0] > 1 && $info[1] > 1) {
                    $imagenData = $data;
                    break;
                }
            }
        }

        if ($imagenData === false) {
            return '';
        }

        $uploadDir = __DIR__ . '/../../public/assets/img/tapas/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
            return '';
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->buffer($imagenData);
        $extensionMap = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        ];
        $extension = $extensionMap[$mime] ?? 'jpg';

        $nombreArchivo = 'ol_' . time() . '_' . uniqid() . '.' . $extension;
        $rutaDestino = $uploadDir . $nombreArchivo;

        if (@file_put_contents($rutaDestino, $imagenData) === false) {
            return '';
        }

        return '/assets/img/tapas/' . $nombreArchivo;
    }

    private function _fetchOpenLibrary(string $url): ?array
    {
        $json = @file_get_contents($url, false, stream_context_create([
            'http' => [
                'timeout' => 8,
                'user_agent' => 'PAWPrints/1.0',
            ],
        ]));

        if ($json === false) return null;

        $data = json_decode($json, true);
        return is_array($data) ? $data : null;
    }

    /**
     * Normaliza fechas estilo "1944", "May 1967", "2020-01-15" a Y-m-d.
     */
    private function _normalizarFecha(string $fecha): string
    {
        $fecha = trim($fecha);
        // Ya está en formato Y-m-d
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            return $fecha;
        }
        // Solo año
        if (preg_match('/^\d{4}$/', $fecha)) {
            return $fecha . '-01-01';
        }
        // Mes Año o "January 15, 2020"
        $ts = strtotime($fecha);
        if ($ts && $ts > 0) {
            return date('Y-m-d', $ts);
        }
        return '';
    }

    private function _procesarImagen(?string $imagenActual, ?array $archivo, string $isbn = ''): string
    {
        // Si no hay archivo nuevo, intentar con Open Library o devolver la actual
        if (!$archivo || $archivo['error'] !== UPLOAD_ERR_OK) {
            if (empty($imagenActual) && !empty($isbn)) {
                $tapaDescargada = $this->descargarTapaOpenLibrary($isbn);
                if (!empty($tapaDescargada)) {
                    return $tapaDescargada;
                }
            }
            return $imagenActual ?? '';
        }

        // Validar tipo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($archivo['type'], $tiposPermitidos)) {
            throw new \InvalidArgumentException("Tipo de archivo no permitido.");
        }

        // Validar tamaño (máx 5 MB)
        if ($archivo['size'] > 5 * 1024 * 1024) {
            throw new \InvalidArgumentException("El archivo supera el tamaño máximo (5 MB).");
        }

        // Crear directorio si no existe
        $uploadDir = __DIR__ . '/../../public/assets/img/tapas/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Nombre único
        $extension    = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $nombreArchivo = 'libro_' . time() . '_' . uniqid() . '.' . $extension;
        $rutaDestino  = $uploadDir . $nombreArchivo;

        if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            throw new \RuntimeException("No se pudo guardar la imagen.");
        }

        return '/assets/img/tapas/' . $nombreArchivo;
    }
}
