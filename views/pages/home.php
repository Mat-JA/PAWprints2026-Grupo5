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
    <title>PawPrints</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <section class="principal">
            <figure>
                <img src="imagenes/frente_libreria_lightmode.png" alt="Frente de la libreria física.">
            </figure>
            <h1>PAWPrints</h1>
            <p>Libreria y espacio de lectura ubicada en Lujan, Buenos Aires. Destinada a toda persona que
                disfrute de un buen libro acompañado de un buen cafe. Veni a visitarnos!</p>
        </section>

        <section class="eventos">
            <h2>Eventos</h2>
            <a href="/eventos.html">
                <img src="/assets/img/evento_portada_generica_index.svg" alt="Evento principal">
                <img src="/assets/img/evento_portada_generica_index.svg" alt="Evento principal 2">
            </a>
        </section>

        <section class="carrusel">
            <h2>Novedades</h2>
            <div>
                <article class="tarjeta-libro">
                    <a href="detalle_libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                    </a>
                    <div>
                        <h3>Título de libro</h3>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" aria-label="Agregar <título de libro> al carrito">Agregar al
                                carrito</button>
                        </form>
                    </div>
                </article>
                <article class="tarjeta-libro">
                    <a href="detalle_libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                    </a>
                    <div>
                        <h3>Título de libro</h3>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" aria-label="Agregar <título de libro> al carrito">Agregar al
                                carrito</button>
                        </form>
                    </div>
                </article>
                <article class="tarjeta-libro">
                    <a href="detalle_libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                    </a>
                    <div>
                        <h3>Título de libro</h3>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" aria-label="Agregar <título de libro> al carrito">Agregar al
                                carrito</button>
                        </form>
                    </div>
                </article>
                <article class="tarjeta-libro">
                    <a href="detalle_libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                    </a>
                    <div>
                        <h3>Título de libro</h3>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" aria-label="Agregar <título de libro> al carrito">Agregar al
                                carrito</button>
                        </form>
                    </div>
                </article>
                <article class="tarjeta-libro">
                    <a href="detalle_libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                    </a>
                    <div>
                        <h3>Título de libro</h3>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" aria-label="Agregar <título de libro> al carrito">Agregar al
                                carrito</button>
                        </form>
                    </div>
                </article>
            </div>
        </section>

        <section class="carrusel">
            <h2>Destacado</h2>
            <div>
                <article class="tarjeta-libro">
                    <a href="detalle_libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                    </a>
                    <div>
                        <h3>Título de libro</h3>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" aria-label="Agregar <título de libro> al carrito">Agregar al
                                carrito</button>
                        </form>
                    </div>
                </article>
                <article class="tarjeta-libro">
                    <a href="detalle_libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                    </a>
                    <div>
                        <h3>Título de libro</h3>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" aria-label="Agregar <título de libro> al carrito">Agregar al
                                carrito</button>
                        </form>
                    </div>
                </article>
                <article class="tarjeta-libro">
                    <a href="detalle_libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro">
                    </a>
                    <div>
                        <h3>Título de libro</h3>
                        <p>$ Precio</p>
                        <form action="/carrito/agregar" method="post">
                            <input type="hidden" name="id_libro" value="123">
                            <input type="hidden" name="título" value="Título del libro">
                            <button type="submit" aria-label="Agregar <título de libro> al carrito">Agregar al
                                carrito</button>
                        </form>
                    </div>
                </article>
            </div>
        </section>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
