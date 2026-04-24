<!DOCTYPE html>

<html lang="es">

<!--DEO GLORIA-->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <link rel="stylesheet" href="/assets/css/base.css">
  <link rel="stylesheet" href="/assets/css/header.css">
  <link rel="stylesheet" href="/assets/css/footer.css">
  <link rel="stylesheet" href="/assets/css/mi_cuenta.css">
  <title>PawPrints - Mi Cuenta</title>
</head>

<body>
  
  <?php require __DIR__ . '/../partials/header.php'; ?>

  <main>
    <h1>Mi Cuenta</h1>
    <p>Nombre de usuario</p>
    <p>Fecha de ingreso</p>
    <img src="/assets/img/logoUsuario.png" alt="Imagen de perfil de usuario" id="userPic">
  </main>

  <section class="misPedidos">
    <header>
      <h2 class="misPedidosTitulo">Mis Pedidos</h2>
    </header>
    <article class="pedido">
      <header>
        <h4 class="titulo">Título, Autor</h4>
      </header>
      <img src="/assets/img/portadaGenerica.png" alt="Portada de un libro sin palabras ni imagenes relevantes" class="portada">
      <p>Fecha Inicio: 28-4-25</p>
      <p>Monto: $43000</p>
      <br />
      <p>Fecha Entrega: 2-5-25</p>
      <p>Estado: Entregado</p>
    </article>
    <article class="pedido">
      <header>
        <h4 class="titulo">Título, Autor</h4>
      </header>
      <img src="/assets/img/portadaGenerica.png" alt="Portada de un libro sin palabras ni imagenes relevantes" class="portada">
      <p>Fecha Inicio: 28-4-25</p>
      <p>Monto: $43000</p>
      <br />
      <p>Fecha Entrega: 2-5-25</p>
      <p>Estado: Entregado</p>
    </article>
  </section>

  <section class="managementLinks">
    <a href="./ajustes" class="bLink">Ajustes</a>
    <a href="./cerrarSesion" class="bLink">Cerrar Sesion</a>
  </section>
  
  <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
