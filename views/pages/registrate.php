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

    <main class="registrate-main">
        <section class="registrate-card">
            <header class="registrate-header">
                <h1 class="registrate-titulo">Registrarme</h1>
            </header>

            <form class="form-registrate" action="" method="post">
                <div class="form-group">
                    <label for="email" class="form-label">Correo electrónico:</label>
                    <input type="email" id="email" name="email" class="form-input" autofocus required>
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>
                
                <div class="form-group">
                    <label for="confirmar" class="form-label">Confirmar contraseña:</label>
                    <input type="password" id="confirmar" name="confirmar" class="form-input" required>
                </div>
                
                <button type="submit" class="btn-registrate">Crear cuenta</button>
            </form>
        </section>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
