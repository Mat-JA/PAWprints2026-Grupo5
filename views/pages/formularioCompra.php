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

    <?php if (!empty($errores)): ?>
      <ul class="errores">
        <?php foreach ($errores as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form method="post" action="/formularioCompra" name="formularioCompra" class="formularioCompra">
      <fieldset>
        <legend class="leyenda">Datos de Envío</legend>
        <label for="envio_nombre">
          Nombre:
          <input required type="text" id="envio_nombre" name="envio_nombre" maxlength="15" minlength="2" />
        </label>
        <br>
        <label for="envio_apellido">
          Apellido:
          <input required type="text" id="envio_apellido" name="envio_apellido" maxlength="25" minlength="2" />
        </label>
        <br>
        <label for="envio_email">
          Email:
          <input required type="email" id="envio_email" name="envio_email" />
        </label>
        <br>
        <label for="envio_pais" class="selectLabel">
          Pais
          <select id="envio_pais" name="envio_pais" class="bSelect">
            <option value="Alemania">Alemania</option>
            <option value="Angola">Angola</option>
            <option value="Australia">Australia</option>
            <option value="Argentina" selected>Argentina</option>
          </select>
        </label>
        <br>
        <label for="envio_provincia">
          Provincia/Estado:
          <input required type="text" id="envio_provincia" name="envio_provincia" />
        </label>
        <br>
        <label for="envio_ciudad">
          Ciudad:
          <input required type="text" id="envio_ciudad" name="envio_ciudad" />
        </label>
        <br>
        <label for="envio_calle">
          Calle:
          <input required type="text" id="envio_calle" name="envio_calle" />
        </label>
        <br>
        <label for="envio_nro_calle">
          Numero de calle:
          <input required type="number" id="envio_nro_calle" name="envio_nro_calle" min="0" step="1" />
        </label>
      </fieldset>
      <br>
      <fieldset>
        <legend class="leyenda">Datos de Facturación</legend>
        <label for="fact_nombre">
          Nombre:
          <input required type="text" id="fact_nombre" name="fact_nombre" maxlength="15" minlength="2" />
        </label>
        <br>
        <label for="fact_apellido">
          Apellido:
          <input required type="text" id="fact_apellido" name="fact_apellido" maxlength="25" minlength="2" />
        </label>
        <br>
        <label for="fact_email">
          Email:
          <input required type="email" id="fact_email" name="fact_email" />
        </label>
        <br>
        <label for="fact_pais" class="selectLabel">
          Pais
          <select id="fact_pais" name="fact_pais" class="bSelect">
            <option value="Alemania">Alemania</option>
            <option value="Angola">Angola</option>
            <option value="Australia">Australia</option>
            <option value="Argentina" selected>Argentina</option>
          </select>
        </label>
        <br>
        <label for="fact_provincia">
          Provincia/Estado:
          <input required type="text" id="fact_provincia" name="fact_provincia" />
        </label>
        <br>
        <label for="fact_ciudad">
          Ciudad:
          <input required type="text" id="fact_ciudad" name="fact_ciudad" />
        </label>
        <br>
        <label for="fact_calle">
          Calle:
          <input required type="text" id="fact_calle" name="fact_calle" />
        </label>
        <br>
        <label for="fact_nro_calle">
          Numero de calle:
          <input required type="number" id="fact_nro_calle" name="fact_nro_calle" min="0" step="1" />
        </label>
        <br>
        <label for="fact_nro_tarjeta">
          Numero de tarjeta:
          <input required type="text" id="fact_nro_tarjeta" name="fact_nro_tarjeta" maxlength="12" minlength="12" pattern="\d{12}" />
        </label>
        <br>
        <label for="fact_vencimiento">
          Vencimiento de tarjeta:
          <input required type="month" id="fact_vencimiento" name="fact_vencimiento" />
        </label>
      </fieldset>
      <br>
      <input type="submit" value="Realizar compra" class="bSubmit">
    </form>
  </main>
  
  <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>