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

  <main class="mi-cuenta-main">
    <section class="mi-cuenta-perfil">
      <img src="/assets/img/logoUsuario.png" alt="Imagen de perfil de usuario" id="userPic" class="user-pic">
      <div class="user-detalles">
        <h1 class="mi-cuenta-titulo">Mi Cuenta</h1>
        <p class="user-name">Nombre de usuario</p>
        <p class="user-date">Fecha de ingreso</p>
      </div>
    </section>

    <section class="misPedidos">
      <header class="mis-pedidos-header">
        <h2 class="misPedidosTitulo">Mis Pedidos</h2>
      </header>
      
      <div class="pedidos-grid">
        <article class="pedido">
          <header class="pedido-header">
            <h3 class="pedido-titulo">Título, Autor</h3>
          </header>
          <img src="/assets/img/portadaGenerica.png" alt="Portada de un libro sin palabras ni imagenes relevantes" class="portada">
          <div class="pedido-detalles">
            <p>Fecha Inicio: 28-4-25</p>
            <p>Monto: $43000</p>
            <p>Fecha Entrega: 2-5-25</p>
            <p>Estado: <span class="estado entregado">Entregado</span></p>
          </div>
        </article>
        
        <article class="pedido">
          <header class="pedido-header">
            <h3 class="pedido-titulo">Título, Autor</h3>
          </header>
          <img src="/assets/img/portadaGenerica.png" alt="Portada de un libro sin palabras ni imagenes relevantes" class="portada">
          <div class="pedido-detalles">
            <p>Fecha Inicio: 28-4-25</p>
            <p>Monto: $43000</p>
            <p>Fecha Entrega: 2-5-25</p>
            <p>Estado: <span class="estado entregado">Entregado</span></p>
          </div>
        </article>
      </div>
    </section>

    <section class="managementLinks">
      <a href="./ajustes" class="bLink">Ajustes</a>
      <a href="./cerrarSesion" class="bLink">Cerrar Sesión</a>
    </section>
  </main>
  
  <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
