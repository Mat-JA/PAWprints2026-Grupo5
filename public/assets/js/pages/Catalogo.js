import { fetchJSON }          from '../modules/api.js';
import { applyFilters }       from '../modules/filters.js';
import { InfiniteScroll }     from '../modules/InfiniteScroll.js';

class Catalogo {
  allBooks = [];
  scroll;

  constructor() {
    this.scroll = new InfiniteScroll({
      containerId: 'books-grid',
      sentinelId:  'sentinel',
      chunk:       20,
      renderFn:    this.renderCard.bind(this),
      loadingEl:   document.getElementById('loading-indicator'),
    });

    this.bindControls();
    this.loadBooks();
  }

  async loadBooks() {
    this.allBooks = await fetchJSON('/api/libros');
    this.update();
  }

  update() {
    const filtered = applyFilters(this.allBooks, this.getState());
    this.scroll.reset(filtered);
  }

  getState() {
    return {
      minPrice:  parseFloat(document.getElementById('min-price').value) || 0,
      maxPrice:  parseFloat(document.getElementById('max-price').value) || Infinity,
      sortField: document.getElementById('sort-field').value,
      sortDir:   document.getElementById('sort-dir').value,
    };
  }

  bindControls() {
    const update = () => this.update();
    document.getElementById('min-price').addEventListener('input', update);
    document.getElementById('max-price').addEventListener('input', update);
    document.getElementById('sort-field').addEventListener('change', update);
    document.getElementById('sort-dir').addEventListener('change', update);

    const toggleBtn = document.querySelector('.btn-toggle-filters');
    const filterPanel = document.querySelector('.filter-panel');
    if (toggleBtn && filterPanel) {
      toggleBtn.addEventListener('click', () => filterPanel.classList.toggle('visible'));
    }
  }

  renderCard(book) {
    const titulo     = this.escape(book.titulo);
    const precio     = book.precio
      ? `$${Number(book.precio).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
      : '$0,00';
    const imgSrc     = this.escape(book.imagen_url);
    const altText    = this.escape(book.titulo);
    const libroId    = book.id;

    const autorNombre = book.autores?.length
      ? book.autores.map(a => this.escape(a.nombre)).join(', ')
      : '';

    return `
      <li>
        <article class="tarjeta-libro">
          <a href="/libro?id=${libroId}">
            <img src="${imgSrc}" alt="${altText}">
          </a>
          <h3>${titulo}</h3>
          ${autorNombre ? `<p class="autor">${autorNombre}</p>` : ''}
          <p class="precio">${precio}</p>
          <a href="/formularioCompra?id=${libroId}" class="btn-comprar">Comprar</a>
        </article>
      </li>
    `;
  }

  escape(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }
}

// ── Boot after DOM is ready ──────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
  new Catalogo();
});
