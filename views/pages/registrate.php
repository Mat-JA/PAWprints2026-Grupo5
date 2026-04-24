<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/print.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/registrate.css">
    <title>PawPrints - Registrate</title>
</head>

<body>
    
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <section>
            <header>
                <h1>Registrarme</h1>
            </header>

            <form class="form-registrate" action="" method="post">
                <label for="email">Correo electronico:</label>
                <input type="email" id="email" autofocus>
                <br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" required>
                <br>
                <label for="confirmar">Confirmar contraseña:</label>
                <input type="password" id="confirmar" required>
                <br>
                <button type="submit" class="btn-registrate">Crear cuenta</button>
                <br>
            </form>
        </section>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
