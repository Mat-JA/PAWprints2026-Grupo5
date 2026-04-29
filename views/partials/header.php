<header>
    <div class="header-top">
        <a href="/">
            <img src="/assets/img/logo.svg" alt="PawPrints">
        </a>

        <form role="search" method="GET" action="/catalogo">
            <input 
                id="busqueda"
                type="search"
                name="buscar"
                placeholder="Buscar libros..."
                value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>"
            >
            <button type="submit">Buscar</button>
        </form>

        <div class="links-header">
            <a href="/carrito">
                <img src="/assets/img/carrito_logo_darkmode.svg" alt="carrito de compras">
            </a>

            <a href="/mi_cuenta">
                <img src="/assets/img/mi_cuenta_logo_darkmode.svg" alt="acceso a mi cuenta">
            </a>
        </div>
    </div>

    <nav aria-label="Navegación principal">
        <ul>
            <li><a href="/catalogo">Libros</a></li>
            <li><a href="/novedades">Novedades</a></li>
            <li><a href="/top_50">Top 50</a></li>
            <li><a href="/eventos">Locales</a></li>
            <li><a href="/nosotros">Contacto</a></li>
        </ul>
    </nav>
</header>