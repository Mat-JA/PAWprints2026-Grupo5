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

    <main>
        <section>
            <h2>Carrito de compras</h2>
            <ul>
                <li>
                    <!-- NOTE:Esto deberia extraerse a item_carrito.html tal vez ?? -->
                    <article>
                        <a href="/libros/libro1">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro: 1">
                        </a>
                        <p>Titulo del libro 1</p>
                        <p>$Precio</p>
                        <button>Eliminar</button>
                    </article>
                </li>
                <li>
                    <article>
                        <a href="/libros/libro2">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro: 2">
                        </a>
                        <p>Titulo del libro 2</p>
                        <p>$Precio</p>
                        <button>Eliminar</button>
                    </article>
                </li>
                <li>
                    <article>
                        <a href="/libros/libro3">
                            <img src="/assets/img/portadaGenerica.png" alt="Portada del libro: 3">
                        </a>
                        <p>Titulo del libro 3</p>
                        <p>$Precio</p>
                        <button>Eliminar</button>
                    </article>
                </li>
            </ul>

            <section>
                <p>Total: $Total</p>
                <button>Realizar compra</button>
            </section>

        </section>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
