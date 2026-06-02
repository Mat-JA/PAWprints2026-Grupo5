<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/header.css">
  <link rel="stylesheet" href="/assets/css/footer.css">
  <link rel="stylesheet" href="/assets/css/abm.css">
  <title>PawPrints - Pedidos</title>
</head>
<body>

  <?php require __DIR__ . '/../partials/header.php'; ?>

  <main class="abm-main">

    <div class="abm-header">
      <h1 class="abm-titulo">Pedidos recibidos</h1>
    </div>

    <div class="abm-tabla-wrapper">
      <table class="abm-tabla">
        <thead>
          <tr>
            <th>#</th>
            <th>Libro</th>
            <th>Cliente</th>
            <th>Email</th>
            <th>Dirección</th>
            <th>País</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($compras)): ?>
            <tr>
              <td colspan="6" style="text-align:center">No hay pedidos registrados.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($compras as $compra): ?>
              <tr>
                <td><?= htmlspecialchars($compra['id']) ?></td>
                <td><?= htmlspecialchars($compra['titulo_libro'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($compra['nombre'] . ' ' . $compra['apellido']) ?></td>
                <td><?= htmlspecialchars($compra['email']) ?></td>
                <td>
                  <?= htmlspecialchars($compra['calle'] . ' ' . $compra['nro_calle'] . ', ' . $compra['ciudad'] . ', ' . $compra['provincia']) ?>
                </td>
                <td><?= htmlspecialchars($compra['pais']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

  </main>

  <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>