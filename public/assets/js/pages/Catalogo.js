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
    this.allBooks = (await fetchJSON('/api/libros')).map(item => item.fields);
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

  // ── Card template – same structure as tarjeta_libro.php ──
  renderCard(book) {
    const titulo  = this.escape(book.titulo);
    const isbn    = book.isbn ? `ISBN: ${this.escape(book.isbn)}` : '';
    const precio  = book.precio
      ? `$${Number(book.precio).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
      : '$0,00';
    const imgSrc  = this.escape(book.imagen_url);          // ⬅️ changed to imagen_url
    const altText = this.escape(book.titulo);
    const libroId = book.id;

    return `
      <li>
        <article class="tarjeta-libro">
          <h3>${titulo}</h3>
          <a href="/libro?id=${libroId}">
            <img src="${imgSrc}" alt="${altText}">
          </a>
          ${isbn ? `<p>${isbn}</p>` : ''}
          <p>${precio}</p>
          <a href="/formularioCompra?id=${libroId}" class="btn-comprar">Agregar al carrito</a>
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
