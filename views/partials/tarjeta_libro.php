<article class="tarjeta-libro">
    <h3><?= htmlspecialchars($libro->fields['titulo']) ?></h3>

    <a href="/libro?id=<?= $libro->fields['id'] ?>">
        <img src="<?= htmlspecialchars($libro->fields['imagen_url']) ?>"
             alt="<?= htmlspecialchars($libro->fields['desc_corta']) ?>">
    </a>

    <p>ISBN: <?= htmlspecialchars($libro->fields['isbn']) ?></p>

    <p>$<?= number_format($libro->fields['precio'] ?? 0, 2, ',', '.') ?></p>

    <a href="/formularioCompra?id=<?= $libro->fields['id'] ?>" class="btn-comprar">Agregar al carrito</a>
</article>
