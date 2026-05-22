<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/error.css">
    <title>PawPrints - Stock insuficiente</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <main class="error-404">
        <h1 class="error-404__code">⚠️</h1>
        <h2 class="error-404__title">Stock Insuficiente</h2>
        <p class="error-404__text">Lo sentimos, no hay suficiente stock disponible para completar la compra.</p>
        <a class="error-404__link" href="/catalogo">Volver al catálogo</a>
    </main>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
