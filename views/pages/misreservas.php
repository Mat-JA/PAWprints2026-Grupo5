<!DOCTYPE html>
<html lang="es_ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/print.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/misReservas.css">
    <title>PawPrints - Mis Reservas</title>
</head>

<body>
    
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main class="reservas-main">

        <h1 class="reservas-titulo">Mis Reservas</h1>
        <ul class="reservas-lista">
            <li class="reserva-item">
                <img src="/assets/img/portadaGenerica.png" alt="detalle imagen libro 1" class="reserva-imagen">
                <div class="reserva-info">
                    <h3 class="reserva-titulo-libro"><a href="/libros/libro1">Titulo del libro 1</a></h3>
                    <p class="reserva-autor">Autor</p>
                    <p class="reserva-isbn">isbn</p>
                    <p class="reserva-descripcion">Descripción</p>
                </div>
                <div class="reserva-meta">
                    <p class="reserva-precio">$Precio</p>
                    <p class="reserva-estado">Estado</p>
                    <button class="btn-eliminar-reserva" aria-label="Eliminar reserva">
                        <img src="/assets/img/iconoEliminar.svg" alt="Eliminar">
                    </button>
                </div>
            </li>
            
            <li class="reserva-item">
                <img src="/assets/img/portadaGenerica.png" alt="detalle imagen libro 2" class="reserva-imagen">
                <div class="reserva-info">
                    <h3 class="reserva-titulo-libro"><a href="/libros/libro2">Titulo del libro 2</a></h3>
                    <p class="reserva-autor">Autor</p>
                    <p class="reserva-isbn">isbn</p>
                    <p class="reserva-descripcion">Descripción</p>
                </div>
                <div class="reserva-meta">
                    <p class="reserva-precio">$Precio</p>
                    <p class="reserva-estado">Estado</p>
                    <button class="btn-eliminar-reserva" aria-label="Eliminar reserva">
                        <img src="/assets/img/iconoEliminar.svg" alt="Eliminar">
                    </button>
                </div>
            </li>
            
            <li class="reserva-item">
                <img src="/assets/img/portadaGenerica.png" alt="detalle imagen libro 3" class="reserva-imagen">
                <div class="reserva-info">
                    <h3 class="reserva-titulo-libro"><a href="/libros/libro3">Titulo del libro 3</a></h3>
                    <p class="reserva-autor">Autor</p>
                    <p class="reserva-isbn">isbn</p>
                    <p class="reserva-descripcion">Descripción</p>
                </div>
                <div class="reserva-meta">
                    <p class="reserva-precio">$Precio</p>
                    <p class="reserva-estado">Estado</p>
                    <button class="btn-eliminar-reserva" aria-label="Eliminar reserva">
                        <img src="/assets/img/iconoEliminar.svg" alt="Eliminar">
                    </button>
                </div>
            </li>
        </ul>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
