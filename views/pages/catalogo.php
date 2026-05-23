<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>PawPrints - Catálogo</title>

    <link rel="stylesheet" href="/assets/css/base.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/catalogo.css">
    <link rel="stylesheet" href="/assets/css/tarjeta_libro.css">

    <script type="module" src="/assets/js/pages/Catalogo.js"></script>
</head>
<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <div class="cabecera-catalogo">
            <h2>Nuestros libros</h2>
            <a href="/catalogo/exportar" class="btn-filtro btn-csv">Descargar CSV</a>
        </div>

        <div class="contenido">
            <div id="books-grid" class="grilla-libros"></div>

            <div id="sentinel" style="display:none;"></div>
            <div id="loading-indicator" style="display:none;">Cargando más libros…</div>

            <aside>
                <button class="btn-toggle-filters" type="button">Filtros</button>
                <div class="filter-panel">
                    <form id="filter-form">
                        <fieldset>
                            <legend>Precio</legend>
                            <label>
                                Mín:
                                <input type="number" id="min-price" inputmode="decimal" placeholder="0" />
                            </label>
                            <label>
                                Máx:
                                <input type="number" id="max-price" inputmode="decimal" placeholder="∞" />
                            </label>
                        </fieldset>

                        <fieldset>
                            <legend>Ordenar</legend>
                            <label>
                                Campo:
                                <select id="sort-field">
                                    <option value="titulo">Título</option>
                                    <option value="autor">Autor</option>
                                    <option value="precio">Precio</option>
                                </select>
                            </label>
                            <label>
                                Dirección:
                                <select id="sort-dir">
                                    <option value="asc">Ascendente</option>
                                    <option value="desc">Descendente</option>
                                </select>
                            </label>
                        </fieldset>
                    </form>
                </div>
            </aside>
        </div>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
