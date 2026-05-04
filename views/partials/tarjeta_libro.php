<article class="tarjeta-libro">
    <h3><?= htmlspecialchars($libro->fields['titulo']) ?></h3>

    <a href="/libro?id=<?= $libro->fields['id'] ?>">
        <img src="<?= htmlspecialchars($libro->fields['imagen_url']) ?>"
             alt="<?= htmlspecialchars($libro->fields['desc_corta']) ?>">
    </a>

    <p>ISBN: <?= htmlspecialchars($libro->fields['isbn']) ?></p>

    <p>$<?= number_format($libro->fields['precio'] ?? 0, 2, ',', '.') ?></p>

    <form action="/carrito/agregar" method="post">
        <input type="hidden" name="id_libro" value="<?= $libro->fields['id'] ?>">
        <input type="hidden" name="titulo" value="<?= htmlspecialchars($libro->fields['titulo']) ?>">
        <button type="submit"
                aria-label="Agregar <?= htmlspecialchars($libro->fields['titulo']) ?> al carrito">
            Agregar al carrito
        </button>
    </form>
</article>
