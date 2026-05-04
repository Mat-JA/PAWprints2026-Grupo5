<!DOCTYPE html>
<html lang="es">

<!--DEO GLORIA-->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/header.css">
  <link rel="stylesheet" href="/assets/css/footer.css">
  <link rel="stylesheet" href="/assets/css/reservaConfirmada.css">
  <title>PawPrints - Reserva confirmada</title>
</head>

<body>

  <?php require __DIR__ . '/../partials/header.php'; ?>

  <main class="confirmacion-main">
      <h1>¡Reserva recibida!</h1>
      <p>Tu reserva fue procesada correctamente. Nos pondremos en contacto a la brevedad.</p>
      <a href="/catalogo" class="btn-volver">Volver al catálogo</a>
  </main>

  <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>