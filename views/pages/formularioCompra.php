<!DOCTYPE html>

<html lang="es">

<!--DEO GLORIA-->

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

  <main>
    <h1>Formulario de compra</h1>

    <?php if (isset($libro)): ?>
      <div class="resumen-libro">
        <img src="<?= htmlspecialchars($libro->fields['imagen_url']) ?>" alt="<?= htmlspecialchars($libro->fields['desc_corta']) ?>" width="100">
        <h2><?= htmlspecialchars($libro->fields['titulo']) ?></h2>
        <p>Precio: $<?= number_format($libro->fields['precio'] ?? 0, 2, ',', '.') ?></p>
      </div>
    <?php endif; ?>

    <form method="post" action="/procesarCompra" name="formularioCompra" class="formularioCompra">
      <input type="hidden" name="id_libro" value="<?= htmlspecialchars($libro->fields['id'] ?? '') ?>">

      <fieldset>
        <legend class="leyenda">Datos de Envío</legend>
        <label for="envio_nombre">
          Nombre:
          <input required type="text" name="envio_nombre" id="envio_nombre" maxlength="15" minlength="2" />
        </label>
        <br>
        <label for="envio_apellido">
          Apellido:
          <input required type="text" name="envio_apellido" id="envio_apellido" maxlength="25" minlength="2" />
        </label>
        <br>
        <label for="envio_email">
          Email:
          <input required type="email" name="envio_email" id="envio_email" />
        </label>
        <br>
        <label for="envio_pais" class="selectLabel">
          Pais
          <select name="envio_pais" id="envio_pais" class="bSelect">
            <option value="Alemania">Alemania</option>
            <option value="Angola">Angola</option>
            <option value="Australia">Australia</option>
            <option value="Argentina" selected>Argentina</option>
          </select>
        </label>
        <br>
        <label for="envio_provincia">
          Provincia/Estado:
          <input required type="text" name="envio_provincia" id="envio_provincia" />
        </label>
        <br>
        <label for="envio_ciudad">
          Ciudad:
          <input required type="text" name="envio_ciudad" id="envio_ciudad" />
        </label>
        <br>
        <label for="envio_calle">
          Calle:
          <input required type="text" name="envio_calle" id="envio_calle" />
        </label>
        <br>
        <label for="envio_nro_calle">
          Numero de calle:
          <input required type="number" name="envio_nro_calle" id="envio_nro_calle" value="" min="0" step="1" />
        </label>
      </fieldset>
      <br>
      <fieldset>
        <legend class="leyenda">Datos de Facturación</legend>
        <label for="fact_nombre">
          Nombre:
          <input required type="text" name="fact_nombre" id="fact_nombre" maxlength="15" minlength="2" />
        </label>
        <br>
        <label for="fact_apellido">
          Apellido:
          <input required type="text" name="fact_apellido" id="fact_apellido" maxlength="25" minlength="2" />
        </label>
        <br>
        <label for="fact_email">
          Email:
          <input required type="email" name="fact_email" id="fact_email" />
        </label>
        <br>
        <label for="fact_pais" class="selectLabel">
          Pais
          <select name="fact_pais" id="fact_pais" class="bSelect">
            <option value="Alemania">Alemania</option>
            <option value="Angola">Angola</option>
            <option value="Australia">Australia</option>
            <option value="Argentina" selected>Argentina</option>
          </select>
        </label>
        <br>
        <label for="fact_provincia">
          Provincia/Estado:
          <input required type="text" name="fact_provincia" id="fact_provincia" />
        </label>
        <br>
        <label for="fact_ciudad">
          Ciudad:
          <input required type="text" name="fact_ciudad" id="fact_ciudad" />
        </label>
        <br>
        <label for="fact_calle">
          Calle:
          <input required type="text" name="fact_calle" id="fact_calle" />
        </label>
        <br>
        <label for="fact_nro_calle">
          Numero de calle:
          <input required type="number" name="fact_nro_calle" id="fact_nro_calle" value="" min="0" step="1" />
        </label>
        <br>
        <label for="fact_nro_tarjeta">
          Numero de tarjeta:
          <input required type="number" name="fact_nro_tarjeta" id="fact_nro_tarjeta" value="" min="0" maxlength="12" minlength="12" />
        </label>
        <br>
        <label for="fact_mes">
          Vencimiento de tarjeta:
          <input required type="month" name="fact_mes" id="fact_mes" />
        </label>
      </fieldset>
      <br>
      <label for="inputSubmit">
        <input required type="submit" name="inputSubmit" value="Realizar compra" class="bSubmit">
      </label>
    </form>
  </main>

  <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
