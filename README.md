# Grupo 5 Programación en Ambiente Web
![Logo de la materia Programación en ambiente web de la UNLu](doc/imgs/logoPAW.svg)

### Integrantes y autores del proyecto
- **Ausqui Mateo**
- **Cacciatore Bautista**
- **Huici Nicolás**
- **Jaime Leandro**

## Proyecto - PAWPrints
Sitio web de una libreria que cuenta con las funcionalidades:
- **Página de inicio**: presentacion de la librería, debe mostrar la tienda en línea y la física.
- **Catálogo de libros**: listado de libros que pueden comprarse en la librería.
- **Formulario de reserva de libro**: formulario donde el usuario ingresa sus datos para comprar un libro.
- **Promociones y marketing**: debe resaltarse una sección especial con información de promociones, descuentos y novedades.
- **Acerca de nosotros**: explica la historia de la librería, su misión y los servicios que ofrece.
- **Info de contacto**: dirección, telefono y e-mail de la tienda.

### Sitemap propuesto
[![Sitemap del sitio web PawPrints](doc/imgs/sitemap.png)](https://www.figma.com/site/Jqh5CYfGCDBkZqZnToXRra/PAWPrints?node-id=0-1&t=73x0IjPEDtp84vHh-1)

**Pueden encontrar el proyecto Figma completo en:**
[Este enlace](https://www.figma.com/site/Jqh5CYfGCDBkZqZnToXRra/PAWPrints?node-id=0-1&t=73x0IjPEDtp84vHh-1)

## Referencias
### Para la realización del trabajo se tomaron cómo referencias las siguientes librerías:

- [Casa del libro](https://www.casadellibro.com)
- [Todos tus libros](https://www.todostuslibros.com/)
- [Yenny el ateneo](https://www.yenny-elateneo.com)
- [Cuspide](https://cuspide.com)

---

## Estructura de directorios propuesta
```
project-root/
├── public/                  # Document root del servidor web (única carpeta expuesta)
│   ├── index.php            # Front controller
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── img/
│   └── favicon.ico
│
├── src/                     # Lógica de aplicación (fuera del document root)
│   ├── Controllers/
│   ├── Model/
│   ├── Core/
│   │    └── Router.php
│   ├── Services/
│   ├── Repository/
│   ├── Middleware/
│   └── bootstrap.php        # Punto de arranque: carga dependencias, config y rutas
│
├── views/                   # Templates PHP
│   ├── layouts/
│   │   └── main.php
│   ├── partials/
│   │   ├── header.php
│   │   └── footer.php
│   └── pages/
│       ├── home.php
│       └── ...
│
├── config/
│   ├── app.php
│   ├── database.php
│   └── routes.php
│
├── storage/
│   ├── logs/
│   ├── cache/
│   └── uploads/
│
├── tests/
├── docker/
│   ├── vhost.conf
│   └── entrypoint.sh
├── vendor/                  # Generado por Composer, no versionar
├── .env                     # Variables de entorno locales, no versionar
├── .env.example
├── docker-compose.yml
├── Dockerfile
└── composer.json
```

---

## Para desarrolladores

### Requisitos previos

- [Docker](https://docs.docker.com/get-docker/) y [Docker Compose](https://docs.docker.com/compose/)
- No se requiere PHP ni Composer instalados localmente; todo corre dentro del contenedor.

### Levantar el entorno

**1. Clonar el repositorio**

```bash
git clone <url-del-repo>
cd PAWprints2026-Grupo5
```

**2. Configurar variables de entorno**

```bash
cp .env.example .env
```

El `.env.example` incluye las variables disponibles con sus descripciones. El `.env` no se versiona (está en `.gitignore`).

Variables actuales:

| Variable    | Default            | Descripción                                                     |
|-------------|--------------------|-----------------------------------------------------------------|
| `LOG_LEVEL` | `DEBUG`            | Nivel de log (DEBUG, INFO, WARNING, ERROR, CRITICAL). Ver [Monolog docs](https://seldaek.github.io/monolog/doc/01-usage.html#log-levels). |
| `LOG_PATH`  | `/storage/logs/app.log` | Path relativo a la raíz del proyecto donde se escribe el log. |

**3. Levantar los contenedores**

```bash
docker compose up --build
```

La primera vez descarga la imagen base de PHP y construye el contenedor. Las siguientes veces basta con `docker compose up`.

El flag `--build` solo es necesario cuando cambia el `Dockerfile`, `composer.json`/`composer.lock`, o archivos dentro de `docker/`.

**Servicios disponibles:**

| Servicio | URL / Puerto local       | Descripción                  |
|----------|--------------------------|------------------------------|
| App PHP  | http://localhost:8080    | Servidor Apache con PHP 8.5  |
| Base de datos | `localhost:5433`    | PostgreSQL 16                |

Credenciales de la DB en desarrollo:

```
Host:     localhost
Puerto:   5433
DB:       pawprintsdb
Usuario:  paw
Password: paw
```

**4. Detener el entorno**

```bash
docker compose down
```

Para eliminar también el volumen de datos de la DB (reset completo):

```bash
docker compose down -v
```

### Flujo de desarrollo

El código fuente está montado como volumen en el contenedor (`- .:/var/www/html:rw`), por lo que **los cambios en archivos PHP se reflejan de inmediato sin necesidad de rebuilds**.

Los únicos casos que requieren `docker compose up --build` son:
- Agregar o actualizar dependencias en `composer.json`
- Modificar el `Dockerfile` o archivos en `docker/`

---

### Arquitectura y convenciones

#### Front Controller

Toda petición HTTP es redirigida por Apache (vía `.htaccess`) a `public/index.php`. El document root del servidor es `public/`, por lo que **nada fuera de esa carpeta es accesible directamente desde el navegador**.

#### Bootstrap

`src/bootstrap.php` es el punto de arranque. Se encarga de:
1. Cargar el autoloader de Composer (`vendor/autoload.php`)
2. Leer el `.env` con `vlucas/phpdotenv`
3. Instanciar `Config` y el logger (`Monolog`)
4. Instanciar el `Router` y registrar todas las rutas

#### Router

El router (`src/Core/Router.php`) es un router simple sin parámetros dinámicos de URL por ahora. Las rutas se registran en `src/bootstrap.php` con la sintaxis:

```php
$router->get('/ruta', 'NombreController@metodo');
$router->post('/ruta', 'NombreController@metodo');
```

El router resuelve el controlador bajo el namespace `App\Controllers\`. Ejemplo:

```php
$router->get('/catalogo', 'PageController@catalogo');
// Instancia App\Controllers\PageController y llama al método catalogo()
```

#### Controladores

Ubicados en `src/Controllers/`. Deben estar bajo el namespace `App\Controllers`. Para renderizar una vista, los controladores hacen `require` directo del archivo PHP correspondiente en `views/`.

```php
// Ejemplo en PageController
public function home()
{
    require $this->viewsDir . 'pages/home.php';
}
```

#### Autoloading

Se usa PSR-4. El namespace raíz `App\` mapea a `src/`. Al crear una clase nueva:

- `src/Controllers/MiController.php` → namespace `App\Controllers`
- `src/Services/MiServicio.php` → namespace `App\Services`
- `src/Model/Libro.php` → namespace `App\Model`

No es necesario hacer ningún `require` manual; Composer se encarga.

#### Logging

El logger (`Monolog`) está disponible como `$log_app` en `public/index.php` (instanciado en bootstrap). Los logs se escriben al path definido en `LOG_PATH` (por default `storage/logs/app.log`).

```php
$log_app->info("Mensaje informativo");
$log_app->error("Error", ["contexto" => $exception]);
```

#### Base de datos

`config/database.php` está vacío por ahora. La conexión a PostgreSQL se configurará ahí. Las credenciales deben venir de variables de entorno, no hardcodeadas.

La DB corre en el servicio `db` del compose. Desde el contenedor `app`, el host para conectarse es `db` (nombre del servicio). Desde el host local, es `localhost:5433`.

---

### Dependencias

Gestionadas con Composer. Las dependencias de producción son:

| Paquete               | Versión  | Uso                                      |
|-----------------------|----------|------------------------------------------|
| `monolog/monolog`     | `^3.10`  | Logging estructurado                     |
| `vlucas/phpdotenv`    | `^5.6`   | Carga de variables desde `.env`          |

Para instalar dependencias localmente (opcional, si tienen PHP 8.5 instalado):

```bash
composer install
```

Para agregar una nueva dependencia:

```bash
# Dentro del contenedor:
docker compose exec app composer require nombre/paquete

# O localmente si tienen PHP 8.5:
composer require nombre/paquete
```

Tras agregar dependencias, hacer commit de `composer.json` y `composer.lock`.
