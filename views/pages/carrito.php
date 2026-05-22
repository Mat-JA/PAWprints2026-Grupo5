<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/carrito.css">
    <title>PawPrint - Carrito</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="carrito-main">
        <section class="carrito-seccion">
            <h2>Carrito de compras</h2>
            <ul class="carrito-lista">
                <li class="carrito-item-li">
                    <article class="carrito-item">
                        <a href="/libros/libro1" class="carrito-portada-link">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro: 1" class="carrito-portada">
                        </a>
                        <h3 class="carrito-titulo">Titulo del libro 1</h3>
                        <p class="carrito-precio">$Precio</p>
                        <button class="btn-eliminar">Eliminar</button>
                    </article>
                </li>
                <li class="carrito-item-li">
                    <article class="carrito-item">
                        <a href="/libros/libro2" class="carrito-portada-link">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro: 2" class="carrito-portada">
                        </a>
                        <h3 class="carrito-titulo">Titulo del libro 2</h3>
                        <p class="carrito-precio">$Precio</p>
                        <button class="btn-eliminar">Eliminar</button>
                    </article>
                </li>
                <li class="carrito-item-li">
                    <article class="carrito-item">
                        <a href="/libros/libro3" class="carrito-portada-link">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro: 3" class="carrito-portada">
                        </a>
                        <h3 class="carrito-titulo">Titulo del libro 3</h3>
                        <p class="carrito-precio">$Precio</p>
                        <button class="btn-eliminar">Eliminar</button>
                    </article>
                </li>
            </ul>

            <div class="carrito-total-container">
                <p class="carrito-total-texto">Total: $Total</p>
                <button class="btn-comprar-realizar">Realizar compra</button>
            </div>

        </section>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
