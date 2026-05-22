<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/header.css">
  <link rel="stylesheet" href="/assets/css/footer.css">
  <link rel="stylesheet" href="/assets/css/formularioCompra.css">

  <title>PawPrints - Formulario de compra</title>
</head>

<body>

  <?php require __DIR__ . '/../partials/header.php'; ?>

  <main class="formulario-compra-main">

    <h1 class="formulario-titulo">Formulario de compra</h1>

    <?php if (isset($libro)): ?>
      <div class="resumen-libro">

        <img
          src="<?= htmlspecialchars($libro->fields['imagen_url']) ?>"
          alt="<?= htmlspecialchars($libro->fields['desc_corta']) ?>"
          width="100"
        >

        <h2>
          <?= htmlspecialchars($libro->fields['titulo']) ?>
        </h2>

        <p>
          Precio:
          $<?= number_format($libro->fields['precio'] ?? 0, 2, ',', '.') ?>
        </p>

      </div>
    <?php endif; ?>

    <form
      method="post"
      action="/procesarCompra"
      name="formularioCompra"
      class="formularioCompra"
    >

      <input
        type="hidden"
        name="id_libro"
        value="<?= htmlspecialchars($libro->fields['id'] ?? '') ?>"
      >

      <fieldset class="formulario-fieldset">

        <label for="nombre" class="formulario-label">
          Nombre:

          <input
            required
            type="text"
            name="nombre"
            id="nombre"
            maxlength="15"
            minlength="2"
          >
        </label>

        <label for="apellido" class="formulario-label">
          Apellido:

          <input
            required
            type="text"
            name="apellido"
            id="apellido"
            maxlength="25"
            minlength="2"
          >
        </label>

        <label for="email" class="formulario-label">
          Email:

          <input
            required
            type="email"
            name="email"
            id="email"
          >
        </label>

        <label
          for="pais"
          class="formulario-label selectLabel"
        >
          País:

          <select
            name="pais"
            id="pais"
            class="bSelect"
          >
            <option value="Alemania">Alemania</option>
            <option value="Angola">Angola</option>
            <option value="Australia">Australia</option>
            <option value="Argentina" selected>Argentina</option>
          </select>
        </label>

        <label for="provincia" class="formulario-label">
          Provincia/Estado:

          <input
            required
            type="text"
            name="provincia"
            id="provincia"
          >
        </label>

        <label for="ciudad" class="formulario-label">
          Ciudad:

          <input
            required
            type="text"
            name="ciudad"
            id="ciudad"
          >
        </label>

        <label for="calle" class="formulario-label">
          Calle:

          <input
            required
            type="text"
            name="calle"
            id="calle"
          >
        </label>

        <label for="nro_calle" class="formulario-label">
          Número de calle:

          <input
            required
            type="number"
            name="nro_calle"
            id="nro_calle"
            min="0"
            step="1"
          >
        </label>

      </fieldset>

      <div class="formulario-submit-container">
        <input
          type="submit"
          name="inputSubmit"
          value="Realizar compra"
          class="bSubmit"
        >
      </div>

    </form>

  </main>

  <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>
</html>