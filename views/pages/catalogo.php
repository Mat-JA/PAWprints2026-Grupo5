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
</head>
<body>
    <?php require __DIR__ . '/../partials/header.php'; ?>

    <main>
        <div class="cabecera-catalogo">
            <h2>Nuestros libros</h2>
            <a href="/catalogo/exportar" class="btn-filtro btn-csv">Descargar CSV</a>
        </div>

        <div class="contenido">
            <!-- Book grid (dynamically filled) -->
            <div id="books-grid" class="grilla-libros"></div>

            <!-- Infinite scroll sentinel and spinner -->
            <div id="sentinel" style="display:none;"></div>
            <div id="loading-indicator" style="display:none;">Cargando más libros…</div>

            <!-- Filter & sort panel (collapsible on mobile) -->
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

                        <fieldset>
                            <legend>Resultados por página</legend>
                            <select id="items-per-page">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20" selected>20</option>
                                <option value="50">50</option>
                            </select>
                        </fieldset>

                        <fieldset>
                            <legend>Modo de paginación</legend>
                            <label>
                                <input type="radio" name="pagination-mode" id="mode-pagination" value="pagination">
                                Tradicional
                            </label>
                            <label>
                                <input type="radio" name="pagination-mode" id="mode-infinite" value="infinite">
                                Scroll infinito
                            </label>
                        </fieldset>
                    </form>
                </div>
            </aside>
        </div>

        <!-- Pagination controls (visible only in traditional mode) -->
        <div id="pagination-controls"></div>
    </main>

    <?php require __DIR__ . '/../partials/footer.php'; ?>

    <!-- Bootstrap the module -->
    <script type="module">
        import { init } from '/assets/js/modules/catalog-filter.js';
        init({
            fetchUrl: '/api/libros',
            containerSelector: '#books-grid',
            itemsPerPageDefault: 20   // default, can be left out
        });
    </script>
</body>
</html>
