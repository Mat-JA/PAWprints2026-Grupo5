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

    <main>

        <h1>Mis Reservas</h1>
        <ul>
            <li>
                <img src="/assets/img/portadaGenerica.png" alt="detalle imagen libro 1">
                <h2><a href="/libros/libro1">Titulo del libro 1</a></h2>
                <p>Autor</p>
                <p>isbn</p>
                <p>Descripción</p>
                <p>$Precio</p>
                <p>Estado</p>
                <button>
                    <img src="/assets/img/iconoEliminar.svg" alt="Eliminar">
                </button>
            </li>
            <li>
                <img src="/assets/img/portadaGenerica.png" alt="detalle imagen libro 2">
                <h2><a href="/libros/libro2">Titulo del libro 2</a></h2>
                <p>Autor</p>
                <p>isbn</p>
                <p>Descripción</p>
                <p>$Precio</p>
                <p>Estado</p>
                <button>
                    <img src="/assets/img/iconoEliminar.svg" alt="Eliminar">
                </button>
            </li>
            <li>
                <img src="/assets/img/portadaGenerica.png" alt="detalle imagen libro 3">
                <h2><a href="/libros/libro3">Titulo del libro 3</a></h2>
                <p>Autor</p>
                <p>isbn</p>
                <p>Descripción</p>
                <p>$Precio</p>
                <p>Estado</p>
                <button>
                    <img src="/assets/img/iconoEliminar.svg" alt="Eliminar">
                </button>
            </li>
        </ul>
    </main>
    
    <?php require __DIR__ . '/../partials/footer.php'; ?>

</body>

</html>
