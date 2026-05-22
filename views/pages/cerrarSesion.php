<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/cerrarSesion.css">
    <title>PawPrints - Login</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="logout-main">
        <section class="logout">
            <h1>Cerrar sesión</h1>
            <p>¡Has cerrado sesión con éxito!</p>
            <a href="/index">Inicio</a>
        </section>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
