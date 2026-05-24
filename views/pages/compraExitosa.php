<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/compraExitosa.css">
    <title>PawPrints - Compra exitosa</title>
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <main class="compra-exitosa-main">
        <section class="compra-exitosa-card">
            <div class="success-icon">✓</div>
            <h1 class="success-titulo">¡Compra realizada con éxito!</h1>
            
            <?php if (isset($libro)): ?>
                <div class="resumen-libro">
                    <img src="<?= htmlspecialchars($libro->fields['imagen_url']) ?>" alt="<?= htmlspecialchars($libro->fields['desc_corta']) ?>" width="100" class="resumen-imagen">
                    <h2 class="resumen-titulo"><?= htmlspecialchars($libro->fields['titulo']) ?></h2>
                    <p class="resumen-precio">Precio: $<?= number_format($libro->fields['precio'] ?? 0, 2, ',', '.') ?></p>
                </div>
            <?php endif; ?>
            
            <p class="success-mensaje">Gracias por tu compra, <?= htmlspecialchars($nombre ?? '') ?>. Te contactaremos pronto.</p>
            <a href="/" class="btn-inicio">Volver al Inicio</a>
        </section>
    </main>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>

</html>
