// DEO GLORIA

// search-history.js - Gestión del historial de búsquedas con Local Storage

const STORAGE_KEY = 'book_search_history';
const MAX_HISTORY = 5;

/**
 * Obtiene el historial de búsquedas desde localStorage
 * @returns {Array<string>} Array con las últimas búsquedas
 */
export function getSearchHistory() {
    try {
        const history = localStorage.getItem(STORAGE_KEY);
        return history ? JSON.parse(history) : [];
    } catch (error) {
        console.error('Error al leer historial:', error);
        return [];
    }
}

/**
 * Guarda una nueva búsqueda en el historial
 * @param {string} searchTerm - Término de búsqueda
 */
export function saveSearch(searchTerm) {
    if (!searchTerm || searchTerm.trim() === '') return;

    try {
        let history = getSearchHistory();

        // Eliminar búsqueda duplicada si existe
        history = history.filter(term => term !== searchTerm);

        // Agregar al inicio
        history.unshift(searchTerm);

        // Mantener solo las últimas 5
        if (history.length > MAX_HISTORY) {
            history = history.slice(0, MAX_HISTORY);
        }

        localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
    } catch (error) {
        console.error('Error al guardar búsqueda:', error);
    }
}

/**
 * Limpia todo el historial
 */
export function clearHistory() {
    try {
        localStorage.removeItem(STORAGE_KEY);
    } catch (error) {
        console.error('Error al limpiar historial:', error);
    }
}

/**
 * Crea el elemento dropdown del historial
 * @param {Array<string>} history - Array de búsquedas
 * @param {Function} onSelectCallback - Callback al seleccionar una búsqueda
 * @returns {HTMLElement} Elemento dropdown
 */
export function createHistoryDropdown(history, onSelectCallback) {
    const dropdown = document.createElement('div');
    dropdown.className = 'search-history-dropdown';
    dropdown.style.display = 'none';

    if (history.length === 0) {
        return dropdown;
    }

    const list = document.createElement('ul');
    list.className = 'search-history-list';

    history.forEach(term => {
        const item = document.createElement('li');
        item.className = 'search-history-item';
        item.textContent = term;
        item.addEventListener('click', () => {
            onSelectCallback(term);
            dropdown.style.display = 'none';
        });
        list.appendChild(item);
    });

    dropdown.appendChild(list);
    return dropdown;
}

/**
 * Muestra u oculta el dropdown
 * @param {HTMLElement} dropdown - Elemento dropdown
 * @param {boolean} show - Mostrar u ocultar
 */
export function toggleDropdown(dropdown, show) {
    dropdown.style.display = show ? 'block' : 'none';
}

/**
 * Inicializa el historial de búsquedas en un formulario
 * @param {HTMLFormElement} form - Formulario que contiene el input
 * @param {HTMLInputElement} input - Input de búsqueda
 */
export function initSearchHistory(form, input) {
    if (!form || !input) return;

    // Envolver input en contenedor si no está
    let searchContainer = input.parentElement;
    if (searchContainer.tagName === 'FORM') {
        const wrapper = document.createElement('div');
        wrapper.className = 'search-container';
        input.parentNode.insertBefore(wrapper, input);
        wrapper.appendChild(input);
        searchContainer = wrapper;
    } else if (!searchContainer.classList.contains('search-container')) {
        searchContainer.classList.add('search-container');
    }

    // Crear dropdown
    const history = getSearchHistory();
    let historyDropdown = createHistoryDropdown(history, (term) => {
        input.value = term;
        toggleDropdown(historyDropdown, false);
        // Enviar formulario automáticamente
        form.submit();
    });
    searchContainer.appendChild(historyDropdown);

    // Mostrar dropdown al hacer focus
    input.addEventListener('focus', () => {
        const updatedHistory = getSearchHistory();
        if (updatedHistory.length > 0) {
            historyDropdown.remove();
            historyDropdown = createHistoryDropdown(updatedHistory, (term) => {
                input.value = term;
                toggleDropdown(historyDropdown, false);
                form.submit();
            });
            searchContainer.appendChild(historyDropdown);
            toggleDropdown(historyDropdown, true);
        }
    });

    // Ocultar dropdown al hacer click fuera
    document.addEventListener('click', (e) => {
        if (!searchContainer.contains(e.target)) {
            toggleDropdown(historyDropdown, false);
        }
    });

    // Guardar búsqueda al enviar el formulario
    form.addEventListener('submit', () => {
        const searchTerm = input.value.trim();
        if (searchTerm.length >= 3) {
            saveSearch(searchTerm);
        }
    });
}