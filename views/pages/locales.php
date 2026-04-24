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

    <main>
        <h1>Eventos locales</h1>
        <section>
            <h2>Nombre Evento 1</h2>
            <h4>fecha evento1</h4>
            <a href="/eventos/1">
                <img src="/assets/img/evento_portada_generica.svg" alt="portada evento 1">
            </a>
        </section>

        <section>
            <h2>Nombre Evento 2</h2>
            <h4>fecha evento2</h4>
            <a href="/eventos/2">
                <img src="/assets/img/evento_portada_generica.svg"  alt="portada evento 1">
            </a>
        </section>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
