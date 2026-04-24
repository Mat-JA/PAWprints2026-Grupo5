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
    <form method="post" name="formularioCompra" class="formularioCompra"> <!--falta URL a la que se envía el post-->
      <fieldset>
        <legend class="leyenda">Datos de Envío</legend>
        <label for="inputNombre">
          Nombre:
          <input required type="text" name="inputNombre" maxlength="15" minlength="2" />
        </label>
        <br>
        <label for="inputApellido">
          Apellido:
          <input required type="text" name="inputApellido" maxlength="25" minlength="2" />
        </label>
        <br>
        <label for="inputEmail">
          Email:
          <input required type="email" name="inputEmail" />
        </label>
        <br>
        <label for="pais" class="selectLabel">
          Pais
          <select name="pais" class="bSelect">
            <option value="Alemania">Alemania</option>
            <option value="Angola">Angola</option>
            <option value="Australia">Australia</option>
            <option value="Argentina" selected>Argentina</option>
          </select>
        </label>
        <br>
        <label for="inputProvincia">
          Provincia/Estado:
          <input required type="text" name="inputProvincia" />
        </label>
        <br>
        <label for="inputCiudad">
          Ciudad:
          <input required type="text" name="inputCiudad" />
        </label>
        <br>
        <label for="inputCalle">
          Calle:
          <input required type="text" name="inputCalle" />
        </label>
        <br>
        <label for="inputNroCalle">
          Numero de calle:
          <input required type="number" name="inputNroCalle" value="" min="0" step="1" />
        </label>
      </fieldset>
      <br>
      <fieldset>
        <legend class="leyenda">Datos de Facturación</legend>
        <label for="inputNombre">
          Nombre:
          <input required type="text" name="inputNombre" maxlength="15" minlength="2" />
        </label>
        <br>
        <label for="inputApellido">
          Apellido:
          <input required type="text" name="inputApellido" maxlength="25" minlength="2" />
        </label>
        <br>
        <label for="inputEmail">
          Email:
          <input required type="email" name="inputEmail" />
        </label>
        <br>
        <label for="pais" class="selectLabel">
          Pais
          <select name="pais" class="bSelect">
            <option value="Alemania">Alemania</option>
            <option value="Angola">Angola</option>
            <option value="Australia">Australia</option>
            <option value="Argentina" selected>Argentina</option>
          </select>
        </label>
        <br>
        <label for="inputProvincia">
          Provincia/Estado:
          <input required type="text" name="inputProvincia" />
        </label>
        <br>
        <label for="inputCiudad">
          Ciudad:
          <input required type="text" name="inputCiudad" />
        </label>
        <br>
        <label for="inputCalle">
          Calle:
          <input required type="text" name="inputCalle" />
        </label>
        <br>
        <label for="inputNroCalle">
          Numero de calle:
          <input required type="number" name="inputNroCalle" value="" min="0" step="1" />
        </label>
        <br>
        <label for="inputNroTarjeta">
          Numero de tarjeta:
          <input required type="number" name="inputNroTarjeta" value="" min="0" maxlength="12" minlength="12" />
        </label>
        <br>
        <label for="inputMes">
          Vencimiento de tarjeta:
          <input required type="month" name="inputMes" />
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
