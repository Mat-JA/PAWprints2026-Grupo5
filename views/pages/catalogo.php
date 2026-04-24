<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>PawPrints - Catalogo</title>

    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/catalogo.css">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <h2>Nuestros libros</h2>
        <div class="contenido">
            <section class="grilla-libros">
                <article>
                    <h3>Titulo</h3>
                    <a href="/libros/libro3">
                        <img src="/assets/img/portadaGenerica.png">
                    </a>
                    <p>Autor del libro</p>
                    <p>$precio</p>
                    <button>Agregar al carrito</button>
                </article>

                <article>
                    <h3>Titulo</h3>
                    <a href="/libros/libro3">
                        <img src="/assets/img/portadaGenerica.png">
                    </a>
                    <p>Autor del libro</p>
                    <p>$precio</p>
                    <button>Agregar al carrito</button>
                </article>

                <article>
                    <h3>Titulo</h3>
                    <a href="/libros/libro3">
                        <img src="/assets/img/portadaGenerica.png">
                    </a>
                    <p>Autor del libro</p>
                    <p>$precio</p>
                    <button>Agregar al carrito</button>
                </article>

                <article>
                    <h3>Titulo</h3>
                    <a href="/libros/libro3">
                        <img src="/assets/img/portadaGenerica.png">
                    </a>
                    <p>Autor del libro</p>
                    <p>$precio</p>
                    <button>Agregar al carrito</button>
                </article>

                <article>
                    <h3>Titulo</h3>
                    <a href="/libros/libro3">
                        <img src="/assets/img/portadaGenerica.png">
                    </a>
                    <p>Autor del libro</p>
                    <p>$precio</p>
                    <button>Agregar al carrito</button>
                </article>

                <article>
                    <h3>Titulo</h3>
                    <a href="/libros/libro3">
                        <img src="/assets/img/portadaGenerica.png">
                    </a>
                    <p>Autor del libro</p>
                    <p>$precio</p>
                    <button>Agregar al carrito</button>
                </article>

                <article>
                    <h3>Titulo</h3>
                    <a href="/libros/libro3">
                        <img src="/assets/img/portadaGenerica.png">
                    </a>
                    <p>Autor del libro</p>
                    <p>$precio</p>
                    <button>Agregar al carrito</button>
                </article>
            </section>

            <aside>
                <details>
                    <summary>Filtros</summary>
                    <form>
                        <fieldset>
                            <legend>Precio</legend>

                            <label>
                                <input type="checkbox" name="precio" value="bajo">
                                Menos de $5000
                            </label>

                            <label>
                                <input type="checkbox" name="precio" value="alto">
                                Más de $5000
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Género</legend>

                            <label>
                                <input type="checkbox" name="genero" value="fantasia">
                                Fantasía
                            </label>

                            <label>
                                <input type="checkbox" name="genero" value="ciencia">
                                Ciencia
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Época</legend>

                            <label>
                                <input type="checkbox" name="epoca" value="moderno">
                                Moderno
                            </label>

                            <label>
                                <input type="checkbox" name="epoca" value="clasico">
                                Clásico
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Fechas</legend>

                            <label>
                                Fecha de ingreso:
                                <input type="date" name="fecha_ingreso">
                            </label>

                            <label>
                                Fecha de edición:
                                <input type="date" name="fecha_edicion">
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Descuentos</legend>

                            <label>
                                <input type="checkbox" name="descuento">
                                Solo con descuento
                            </label>
                        </fieldset>

                        <button type="submit">Aplicar filtros</button>
                    </form>
                </details>
            </aside>
        </div>

        <nav class="paginacion">
            <ul>
                <li><a href="pagina/1">ant</a></li>
                <li><a href="pagina/1">1</a></li>
                <li><a href="pagina/2">2</a></li>
                <li><a href="pagina/3">3</a></li>
                <li><a href="pagina/2">sig</a></li>
            </ul>
        </nav>
    </main>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
