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

    <main class="login-main">
        <section class="login-card">
            <header class="login-header">
                <h1 class="login-titulo">Iniciar Sesión</h1>
            </header>

            <form class="form-login" action="" method="post">
                <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico:</label>
                    <input type="email" id="email" name="email" class="form-input" autofocus required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                
                <button type="submit" class="btn-login">Acceder</button>
            </form>

            <p class="login-registrar-link">
                ¿No tenés cuenta?
                <a href="/registrate">Registrate aquí</a>
            </p>
        </section>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
