<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página no encontrada</title>
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/error.css">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="error-404">
        <h1 class="error-404__code">404</h1>
        <h2 class="error-404__title">Página no encontrada</h2>
        <p class="error-404__text">La página que intentás acceder no existe.</p>

        <a class="error-404__link" href="/catalogo">Volver al catálogo</a>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
