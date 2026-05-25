// catalog-filter.js – Client‑side catalog with filtering, sorting, pagination & infinite scroll.

import { fetchJSON }          from '../modules/api.js';
import { applyFilters }       from '../modules/filters.js';
import { InfiniteScroll }     from '../modules/InfiniteScroll.js';

/* ── Private state ────────────────────────────────────────── */
let _initialised = false;
let booksData = [];
let container, fetchUrl;
let currentFilters = {
    minPrice:  0,
    maxPrice:  Infinity,
    sortField: 'titulo',
    sortDir:   'asc',
};
let pagination = {
    currentPage:  1,
    itemsPerPage: 20,
    totalItems:   0,
    mode:         'infinite',          // overridden by viewport in init
};
let scrollInstance = null;
let sentinelEl, loadingEl, paginationControlsEl,
    itemsPerPageSelect, radioPagination, radioInfinite;
let filterPanel, toggleBtn;
let debounceTimer;
let userHasInteracted = false;

/* ── Public API ───────────────────────────────────────────── */
export function init(config) {
    if (_initialised) return;
    _initialised = true;

    container            = document.querySelector(config.containerSelector);
    fetchUrl             = config.fetchUrl;
    pagination.itemsPerPage = config.itemsPerPageDefault || 20;

    // Cache DOM
    sentinelEl            = document.getElementById('sentinel');
    loadingEl             = document.getElementById('loading-indicator');
    paginationControlsEl  = document.getElementById('pagination-controls');
    itemsPerPageSelect    = document.getElementById('items-per-page');
    radioPagination       = document.getElementById('mode-pagination');
    radioInfinite         = document.getElementById('mode-infinite');
    filterPanel           = document.querySelector('.filter-panel');
    toggleBtn             = document.querySelector('.btn-toggle-filters');

    const minPriceEl      = document.getElementById('min-price');
    const maxPriceEl      = document.getElementById('max-price');
    const sortFieldEl     = document.getElementById('sort-field');
    const sortDirEl       = document.getElementById('sort-dir');

    // Initial mode based on viewport
    setDefaultModeByWidth();
    window.addEventListener('resize', () => {
        if (!userHasInteracted) setDefaultModeByWidth();
    });

    // Event binding
    const updateAndRender = () => {
        currentFilters.minPrice   = parseFloat(minPriceEl.value) || 0;
        currentFilters.maxPrice   = parseFloat(maxPriceEl.value) || Infinity;
        currentFilters.sortField  = sortFieldEl.value;
        currentFilters.sortDir    = sortDirEl.value;
        pagination.currentPage    = 1;
        render();
    };

    minPriceEl.addEventListener('input',   debounce(updateAndRender, 300));
    maxPriceEl.addEventListener('input',   debounce(updateAndRender, 300));
    sortFieldEl.addEventListener('change', updateAndRender);
    sortDirEl.addEventListener('change',   updateAndRender);

    itemsPerPageSelect.addEventListener('change', e => {
        pagination.itemsPerPage = parseInt(e.target.value, 10);
        pagination.currentPage  = 1;
        render();
    });

    radioPagination?.addEventListener('change', () => {
        if (radioPagination.checked) switchMode('pagination');
    });
    radioInfinite?.addEventListener('change', () => {
        if (radioInfinite.checked) switchMode('infinite');
    });

    toggleBtn?.addEventListener('click', () => filterPanel?.classList.toggle('visible'));

    // Fetch all books, then render
    fetchJSON(fetchUrl).then(data => {
        booksData = data.map(item => item.fields);
        render();
    });
}

/* ── Mode helpers ─────────────────────────────────────────── */
function setDefaultModeByWidth() {
    const isMobile = window.innerWidth < 768;
    pagination.mode = isMobile ? 'infinite' : 'pagination';
    if (radioPagination && radioInfinite) {
        radioPagination.checked = !isMobile;
        radioInfinite.checked   = isMobile;
    }
}

function switchMode(mode) {
    pagination.mode = mode;
    userHasInteracted = true;
    pagination.currentPage = 1;
    render();
}

/* ── Data pipeline ────────────────────────────────────────── */
function getFilteredSorted() {
    return applyFilters(booksData, currentFilters);
}

/* ── Render dispatcher ────────────────────────────────────── */
function render() {
    const filtered = getFilteredSorted();
    pagination.totalItems = filtered.length;

    if (pagination.mode === 'infinite') {
        renderInfinite(filtered);
    } else {
        renderPaginated(filtered);
    }
}

/* ── Infinite scroll rendering ────────────────────────────── */
function renderInfinite(items) {
    paginationControlsEl.style.display = 'none';
    sentinelEl.style.display           = 'block';
    loadingEl.style.display            = 'none';

    if (!scrollInstance) {
        scrollInstance = new InfiniteScroll({
            containerId: container.id,
            sentinelId:  sentinelEl.id,
            chunk:       pagination.itemsPerPage,
            renderFn:    renderCard,
            loadingEl,                     // ⬅️ passed to show/hide spinner
        });
    }
    scrollInstance.reset(items);
}

/* ── Traditional pagination rendering ─────────────────────── */
function renderPaginated(items) {
    // Kill infinite scroll observer
    if (scrollInstance) {
        if (scrollInstance.observer) scrollInstance.observer.disconnect();
        scrollInstance = null;
    }
    sentinelEl.style.display = 'none';
    loadingEl.style.display  = 'none';
    paginationControlsEl.style.display = 'block';

    const start = (pagination.currentPage - 1) * pagination.itemsPerPage;
    const end   = Math.min(start + pagination.itemsPerPage, items.length);
    if (start >= items.length && items.length > 0) {
        pagination.currentPage = Math.max(1, Math.ceil(items.length / pagination.itemsPerPage));
        renderPaginated(items);
        return;
    }
    const pageItems = items.slice(start, end);

    container.innerHTML = '';
    pageItems.forEach(book => container.insertAdjacentHTML('beforeend', renderCard(book)));

    renderPaginationControls();
}

function renderCard(book) {
    return `
        <div class="book-card">
            <img src="${book.imagen_url || ''}" alt="${book.titulo}">
            <h3>${book.titulo}</h3>
            <span>$${book.precio}</span>
        </div>
    `;
}

/* ── Page links ───────────────────────────────────────────── */
function renderPaginationControls() {
    const totalPages = Math.ceil(pagination.totalItems / pagination.itemsPerPage);
    const current    = pagination.currentPage;
    const maxNeighbors = window.innerWidth < 768 ? 1 : 2;

    let html = `<div class="pagination-summary">Mostrando ${(current-1)*pagination.itemsPerPage + 1}–${Math.min(current*pagination.itemsPerPage, pagination.totalItems)} de ${pagination.totalItems} resultados</div>`;
    html += '<ul class="pagination-list">';

    // Prev
    html += `<li><button class="page-btn"${current === 1 ? ' disabled' : ''} data-page="${current-1}">&lt;</button></li>`;

    // First page
    if (current > 1 + maxNeighbors) {
        html += `<li><button class="page-btn" data-page="1">1</button></li>`;
        if (current > 2 + maxNeighbors) html += '<li class="ellipsis">…</li>';
    }

    // Surrounding pages
    for (let i = Math.max(1, current - maxNeighbors); i <= Math.min(totalPages, current + maxNeighbors); i++) {
        html += `<li><button class="page-btn${i === current ? ' active' : ''}" data-page="${i}">${i}</button></li>`;
    }

    // Last page
    if (current < totalPages - maxNeighbors) {
        if (current < totalPages - maxNeighbors - 1) html += '<li class="ellipsis">…</li>';
        html += `<li><button class="page-btn" data-page="${totalPages}">${totalPages}</button></li>`;
    }

    // Next
    html += `<li><button class="page-btn"${current === totalPages ? ' disabled' : ''} data-page="${current+1}">&gt;</button></li>`;
    html += '</ul>';

    paginationControlsEl.innerHTML = html;

    // Click handlers
    paginationControlsEl.querySelectorAll('.page-btn:not([disabled])').forEach(btn => {
        btn.addEventListener('click', function () {
            const page = parseInt(this.dataset.page, 10);
            if (page >= 1 && page <= totalPages) {
                pagination.currentPage = page;
                render();
            }
        });
    });
}

/* ── Debounce utility ─────────────────────────────────────── */
function debounce(fn, delay) {
    return function (...args) {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fn.apply(this, args), delay);
    };
}
