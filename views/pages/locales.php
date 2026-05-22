<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/print.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/locales.css">
    <title>PawPrints - Eventos Locales</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="locales-main">
        <h1 class="locales-titulo">Eventos locales</h1>
        
        <div class="eventos-lista">
            <section class="evento-card">
                <h2 class="evento-titulo">Nombre Evento 1</h2>
                <time class="evento-fecha">fecha evento1</time>
                <a href="/eventos/1" class="evento-imagen-link">
                    <img src="/assets/img/evento_portada_generica.svg" alt="portada evento 1">
                </a>
            </section>

            <section class="evento-card">
                <h2 class="evento-titulo">Nombre Evento 2</h2>
                <time class="evento-fecha">fecha evento2</time>
                <a href="/eventos/2" class="evento-imagen-link">
                    <img src="/assets/img/evento_portada_generica.svg" alt="portada evento 2">
                </a>
            </section>
        </div>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
