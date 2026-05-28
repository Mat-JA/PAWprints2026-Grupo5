<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/header.css">
  <link rel="stylesheet" href="/assets/css/footer.css">
  <link rel="stylesheet" href="/assets/css/imagedropzone.css">
  <link rel="stylesheet" href="/assets/css/abm.css">
  <title>PawPrints - ABM Libros</title>
</head>
<body>

  <?php require __DIR__ . '/../partials/header.php'; ?>

  <main class="abm-main">

    <div class="abm-header">
      <h1 class="abm-titulo">Administración de libros</h1>
      <button class="abm-btn-nuevo" id="btn-nuevo">+ Nuevo libro</button>
    </div>

    <?php if (isset($_GET['exito'])): ?>
      <div class="abm-alerta abm-alerta--exito">
        <?php
          $msgs = [
            'creado'     => '✅ Libro creado correctamente.',
            'actualizado'=> '✅ Libro actualizado correctamente.',
            'eliminado'  => '✅ Libro eliminado correctamente.',
          ];
          echo $msgs[$_GET['exito']] ?? '✅ Operación realizada.';
        ?>
      </div>
    <?php endif; ?>

    <!-- ── Tabla de libros ── -->
    <div class="abm-tabla-wrapper">
      <table class="abm-tabla">
        <thead>
          <tr>
            <th>Tapa</th>
            <th>Título</th>
            <th>ISBN</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($libros as $libro): ?>
            <tr>
              <td>
                <?php if ($libro->fields['imagen_url']): ?>
                  <img
                    src="<?= htmlspecialchars($libro->fields['imagen_url']) ?>"
                    alt="Tapa"
                    class="abm-tabla-tapa"
                  >
                <?php else: ?>
                  <span class="abm-sin-imagen">Sin imagen</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($libro->fields['titulo']) ?></td>
              <td><?= htmlspecialchars($libro->fields['isbn']) ?></td>
              <td>$<?= number_format($libro->fields['precio'], 2, ',', '.') ?></td>
              <td><?= htmlspecialchars($libro->fields['stock']) ?></td>
              <td>
                <button
                  class="abm-btn-editar"
                  data-libro='<?= htmlspecialchars(json_encode($libro->fields), ENT_QUOTES) ?>'
                >
                  Editar
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <!-- ── Panel lateral (crear / editar) ── -->
    <div class="abm-panel" id="abm-panel" hidden>

      <div class="abm-panel-header">
        <h2 class="abm-panel-titulo" id="panel-titulo">Nuevo libro</h2>
        <button class="abm-panel-cerrar" id="btn-cerrar-panel" aria-label="Cerrar panel">✕</button>
      </div>

      <!-- Formulario crear -->
      <form
        method="post"
        action="/admin/abm/crear"
        enctype="multipart/form-data"
        class="abm-form"
        id="form-crear"
      >
        <?php include __DIR__ . '/../partials/abm_campos.php'; ?>
        <div class="abm-form-actions">
          <input type="submit" value="Crear libro" class="bSubmit">
        </div>
      </form>

      <!-- Formulario editar -->
      <form
        method="post"
        action="/admin/abm/actualizar"
        enctype="multipart/form-data"
        class="abm-form"
        id="form-editar"
        hidden
      >
        <input type="hidden" name="id" id="edit-id">
        <?php include __DIR__ . '/../partials/abm_campos.php'; ?>
        <div class="abm-form-actions">
          <input type="submit" value="Guardar cambios" class="bSubmit">
          <button type="button" class="abm-btn-eliminar" id="btn-eliminar">Eliminar libro</button>
        </div>
      </form>

      <!-- Form eliminar (oculto, se envía por JS) -->
      <form
        method="post"
        action="/admin/abm/eliminar"
        id="form-eliminar"
        hidden
      >
        <input type="hidden" name="id" id="eliminar-id">
      </form>

    </div>

  </main>

  <?php require __DIR__ . '/../partials/footer.php'; ?>

  <script src="/assets/js/imageDropzone.js"></script>
  <script src="/assets/js/abm.js"></script>

</body>
</html>
