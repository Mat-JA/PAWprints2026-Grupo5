<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/print.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/login.css">
    <title>PawPrints - Login</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <section>
            <header>
                <h1>Iniciar Sesion</h1>
            </header>

            <form class="form-login" action="" method="post">
                <label for="email">Correo electronico:</label>
                <input type="email" id="email" autofocus>
                <br>
                <label for="password">Contraseña:</label>
                <input type="password" id="password" required>
                <br>
                <button type="submit" class="btn-login">Acceder</button>
                <br>
            </form>

            <p>
                ¿No tenes cuenta?
                <a href="/registrate">Registrate aqui</a>
            </p>
        </section>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
