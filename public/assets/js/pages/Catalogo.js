import { fetchJSON }    from '../modules/api.js';
import { applyFilters } from '../modules/filters.js';

class Catalogo {
  #allBooks = [];
  #scroll;

  constructor() {
    this.#scroll = new InfiniteScroll({
      containerId: 'books-grid',
      sentinelId:  'sentinel',
      chunk:       20,
      renderFn:    this.#renderCard,
    });

    this.#bindControls();
    this.#loadBooks();
  }

  async #loadBooks() {
    this.#allBooks = await fetchJSON('/api/libros');
    this.#update();
  }

  #update() {
    const filtered = applyFilters(this.#allBooks, this.#getState());
    this.#scroll.reset(filtered);
  }

  #getState() {
    return {
      minPrice:  parseFloat(document.getElementById('min-price').value) || 0,
      maxPrice:  parseFloat(document.getElementById('max-price').value),
      sortField: document.getElementById('sort-field').value,
      sortDir:   document.getElementById('sort-dir').value,
    };
  }

  #bindControls() {
    const update = () => this.#update();
    ['min-price', 'max-price'].forEach(id =>
      document.getElementById(id).addEventListener('input', update)
    );
    ['sort-field', 'sort-dir'].forEach(id =>
      document.getElementById(id).addEventListener('change', update)
    );
  }

  #renderCard(book) {
    return `
      <div class="book-card">
        <img src="${book.imagen}" alt="${book.titulo}">
        <h3>${book.titulo}</h3>
        <p>${book.autor}</p>
        <span>$${book.precio}</span>
      </div>
    `;
  }
}

new CatalogPage();
