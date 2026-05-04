<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>PawPrints - Catalogo</title>

    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/catalogo.css">
    <link rel="stylesheet" href="/assets/css/tarjeta_libro.css">
</head>

<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <div class="cabecera-catalogo">
            <h2>Nuestros libros</h2>

            <a href="/catalogo/exportar" class="btn-filtro btn-csv">
                Descargar CSV
            </a>
        </div>
        <div class="contenido">
            <section class="grilla-libros">

            <?php foreach ($libros as $libro): ?>
                <?php require __DIR__ . '/../partials/tarjeta_libro.php'; ?>
            <?php endforeach; ?>

            </section>

            <aside>
                <details>
                    <summary>Filtros</summary>
                    <form>
                        <fieldset>
                            <legend>Precio</legend>

                            <label>
                                <input type="checkbox" name="precio" value="bajo">
                                Menos de $5000
                            </label>

                            <label>
                                <input type="checkbox" name="precio" value="alto">
                                Más de $5000
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Género</legend>

                            <label>
                                <input type="checkbox" name="genero" value="fantasia">
                                Fantasía
                            </label>

                            <label>
                                <input type="checkbox" name="genero" value="ciencia">
                                Ciencia
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Época</legend>

                            <label>
                                <input type="checkbox" name="epoca" value="moderno">
                                Moderno
                            </label>

                            <label>
                                <input type="checkbox" name="epoca" value="clasico">
                                Clásico
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Fechas</legend>

                            <label>
                                Fecha de ingreso:
                                <input type="date" name="fecha_ingreso">
                            </label>

                            <label>
                                Fecha de edición:
                                <input type="date" name="fecha_edicion">
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Descuentos</legend>

                            <label>
                                <input type="checkbox" name="descuento">
                                Solo con descuento
                            </label>
                        </fieldset>

                        <button type="submit">Aplicar filtros</button>
                    </form>
                </details>
            </aside>
        </div>

        <nav class="paginacion">
            <ul>

                <?php if ($pagina > 1): ?>
                    <li><a href="/catalogo?pagina=<?= $pagina - 1 ?>">ant</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li>
                        <a href="/catalogo?pagina=<?= $i ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($pagina < $totalPaginas): ?>
                    <li><a href="/catalogo?pagina=<?= $pagina + 1 ?>">sig</a></li>
                <?php endif; ?>

            </ul>
        </nav>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
