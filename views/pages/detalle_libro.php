<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/detalle_libro.css">
    <title>PawPrints - <?= $libro->fields['descripcion_corta'] ?></title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>

        <section>
            <article class="detalle-libro">

                <section class="datos-libro">

                    <div class="portada-libro">
                        <img 
                            src="<?= $libro->fields['imagen_url'] ?>" 
                            alt="Portada del libro" 
                            class="imgPortada"
                        >
                    </div>

                    <div class="texto-datos-libro">

                        <h1><?= $libro->fields['descripcion_corta'] ?></h1>

                        <h2><?= $libro->fields['isbn'] ?></h2>

                        <p>Precio: $<?= $libro->fields['precio'] ?></p>

                        <p>Stock: <?= $libro->fields['stock'] ?></p>

                        <button>Agregar al carrito</button>

                        <p>Puntuación: 5/5</p>

                    </div>

                </section>

                <section class="descripcion-libro">

                    <h2>Descripción</h2>

                    <p>
                        <?= $libro->fields['descripcion_completa'] ?>
                    </p>

                </section>

            </article>
        </section>

        <section class="comentarios">

            <h2>Comentarios</h2>

            <article class="opinion">
                <div class="opinion-datos">
                    <p>Juan Apellido</p>
                    <p>dd/mm/aaaa</p>
                    <p>Puntuación: 5/5</p>
                </div>
                <div class="opinion-texto">
                    <p>Lorem ipsum dolor sit amet...</p>
                </div>
            </article>

        </section>

    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>