<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <title>PawPrints - Compra exitosa</title>
</head>
<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>
    <main>
        <h1>¡Compra realizada con éxito!</h1>
        <?php if (isset($libro)): ?>
            <div class="resumen-libro">
                <img src="<?= htmlspecialchars($libro->fields['imagen_url']) ?>" alt="<?= htmlspecialchars($libro->fields['desc_corta']) ?>" width="100">
                <h2><?= htmlspecialchars($libro->fields['titulo']) ?></h2>
                <p>Precio: $<?= number_format($libro->fields['precio'] ?? 0, 2, ',', '.') ?></p>
            </div>
        <?php endif; ?>
        <p>Gracias por tu compra. Te contactaremos pronto.</p>
    </main>
    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
