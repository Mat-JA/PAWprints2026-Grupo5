// DEO GLORIA

// header-search.js - Inicializa el historial de búsquedas en el header

import { initSearchHistory } from './search-history.js';

document.addEventListener('DOMContentLoaded', () => {
    const searchForm = document.querySelector('header form[role="search"]');
    const searchInput = document.getElementById('busqueda');

    if (searchForm && searchInput) {
        initSearchHistory(searchForm, searchInput);
    }
});