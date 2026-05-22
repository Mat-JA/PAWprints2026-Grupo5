<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/print.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/index.css">
    <link rel="stylesheet" href="/assets/css/tarjeta_libro.css">
    <link rel="stylesheet" href="/assets/css/carousel.css">
    <link rel="stylesheet" href="/assets/css/carousel-eventos.css">
    <title>PawPrints</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <section class="principal">
            <figure>
                <img src="/assets/img/frente_libreria_lightmode.png" alt="Frente de la libreria física.">
            </figure>
            <h1>PAWPrints</h1>
            <p>Libreria y espacio de lectura ubicada en Lujan, Buenos Aires. Destinada a toda persona que
                disfrute de un buen libro acompañado de un buen cafe. Veni a visitarnos!</p>
        </section>

        <section class="eventos">
            <h2>Eventos</h2>
            <div class="eventos-carousel">
                <img src="/assets/img/evento_portada_generica_index.svg" alt="Evento principal 1">
                <img src="/assets/img/evento_portada_generica_index.svg" alt="Evento principal 2">
                <img src="/assets/img/evento_portada_generica_index.svg" alt="Evento principal 3">
            </div>
        </section>

        <section class="novedades">
            <h2>Novedades</h2>
            <ul class="grilla-libros">
                <li>
                    <article class="tarjeta-libro">
                        <h3>Título de libro</h3>
                        <a href="detalle_libro">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                        </a>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" class="btn-comprar" aria-label="Agregar al carrito">Agregar al carrito</button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="tarjeta-libro">
                        <h3>Título de libro</h3>
                        <a href="detalle_libro">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                        </a>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" class="btn-comprar" aria-label="Agregar al carrito">Agregar al carrito</button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="tarjeta-libro">
                        <h3>Título de libro</h3>
                        <a href="detalle_libro">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                        </a>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" class="btn-comprar" aria-label="Agregar al carrito">Agregar al carrito</button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="tarjeta-libro">
                        <h3>Título de libro</h3>
                        <a href="detalle_libro">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                        </a>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" class="btn-comprar" aria-label="Agregar al carrito">Agregar al carrito</button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="tarjeta-libro">
                        <h3>Título de libro</h3>
                        <a href="detalle_libro">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                        </a>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" class="btn-comprar" aria-label="Agregar al carrito">Agregar al carrito</button>
                        </form>
                    </article>
                </li>
            </ul>
        </section>
 
        <section class="destacados">
            <h2>Destacados</h2>
            <ul class="grilla-libros">
                <li>
                    <article class="tarjeta-libro">
                        <h3>Título de libro</h3>
                        <a href="detalle_libro">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                        </a>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" class="btn-comprar" aria-label="Agregar al carrito">Agregar al carrito</button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="tarjeta-libro">
                        <h3>Título de libro</h3>
                        <a href="detalle_libro">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                        </a>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" class="btn-comprar" aria-label="Agregar al carrito">Agregar al carrito</button>
                        </form>
                    </article>
                </li>
                <li>
                    <article class="tarjeta-libro">
                        <h3>Título de libro</h3>
                        <a href="detalle_libro">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                        </a>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" class="btn-comprar" aria-label="Agregar al carrito">Agregar al carrito</button>
                        </form>
                    </article>
                </li>
            </ul>
        </section>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

    <script src="/assets/js/carousel.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            new Carousel(".eventos-carousel", {
                autoplay: true,
                delay: 3000,
                transition: "zoom"
            });
        });
    </script>
</body>

</html>