<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/detalle_libro.css">
    <title>PawPrints - <?= htmlspecialchars($libro->fields['desc_corta'] ?? '') ?></title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>

        <section>
            <article class="detalle-libro">

                <section class="datos-libro">

                    <div class="portada-libro">
                        <img 
                            src="<?= htmlspecialchars($libro->fields['imagen_url'] ?? '') ?>" 
                            alt="Portada del libro" 
                            class="imgPortada"
                        >
                    </div>

                    <div class="texto-datos-libro">

                        <h1><?= htmlspecialchars($libro->fields['desc_corta'] ?? '') ?></h1>

                        <h2><?= htmlspecialchars($libro->fields['isbn'] ?? '') ?></h2>

                        <p>Precio: $<?= number_format($libro->fields['precio'] ?? 0, 2, ',', '.') ?></p>

                        <p>Stock: <?= htmlspecialchars($libro->fields['stock'] ?? '') ?></p>

                        <button>Agregar al carrito</button>

                        <p>Puntuación: 5/5</p>

                    </div>

                </section>

                <section class="descripcion-libro">

                    <h2>Descripción</h2>

                    <p>
                        <?= htmlspecialchars($libro->fields['descripcion'] ?? '') ?>
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
