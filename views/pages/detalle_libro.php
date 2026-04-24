<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/detalle_libro.css">
    <title>PawPrints - Libro</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <section>
            <article class="detalle-libro">
                <section class="datos-libro">
                    <div class="portada-libro">
                        <img src="/assets/img/portadaGenerica.png" alt="Portada del libro" class="imgPortada">
                    </div>

                    <div class="texto-datos-libro">
                        <h1>El camino de los reyes</h1>
                        <h2>Brandon Sanderson</h2>

                        <p>Precio: $111</p>

                        <button>Agregar al carrito</button>

                        <p>Puntuacion: 5/5</p>
                    </div>
                </section>

                <section class="descripcion-libro">
                    <h2>Descripción</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipiscing, elit blandit ultrices consequat ac sociosqu
                        dignissim, phasellus cum libero nullam massa. Venenatis facilisi ultrices phasellus est non eget
                        et
                        lectus, mi curabitur felis nascetur suspendisse hendrerit duis aliquam quis, cubilia interdum
                        purus
                        a urna curae fermentum. Porta dignissim nulla phasellus proin senectus imperdiet fames, facilisi
                        malesuada mauris porttitor interdum turpis, aliquet vulputate vel integer conubia habitasse.

                        Sem enim pharetra facilisis id a nascetur massa risus sollicitudin, suscipit vitae convallis
                        neque
                        ac cras consequat. Orci semper nec vehicula rutrum potenti imperdiet fusce varius netus,
                        condimentum
                        porttitor magna dictumst mollis lacinia habitasse ridiculus faucibus, mi aptent turpis vel proin
                        mattis leo fringilla. Torquent conubia purus vel dapibus tempor vivamus integer pharetra
                        ultrices
                        iaculis, dictum posuere eleifend nec primis dis auctor semper sollicitudin duis, ridiculus massa
                        molestie nulla platea vitae morbi nunc quisque.
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
                    <p>Puntuacion: 5/5</p>
                </div>
                <div class="opinion-texto">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eget dui non dui congue pharetra.
                        Duis
                        lobortis convallis nisi eu dapibus. Morbi condimentum pharetra dolor, id consectetur nisl
                        viverra
                        vel.</p>
                </div>
            </article>

            <article class="opinion">
                <div class="opinion-datos">
                    <p>María Apellido</p>
                    <p>dd/mm/aaaa</p>
                    <p>Puntuacion: 5/5</p>
                </div>
                <div class="opinion-texto">
                    <p>Cras sed eleifend est. Morbi ut ullamcorper ante. Pellentesque congue porta dolor a imperdiet.
                        Morbi
                        porta quis dui quis tincidunt.</p>
                </div>
            </article>
        </section>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
