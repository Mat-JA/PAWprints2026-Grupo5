/**
 * ImageDropzone
 * Componente de carga de imágenes vía Drag & Drop.
 * 
 * Uso:
 *   new ImageDropzone('#mi-contenedor', { maxSizeMB: 5, accept: ['image/jpeg', 'image/png', 'image/webp'] });
 * 
 * El contenedor debe tener un <input type="file"> adentro, o se crea uno automáticamente.
 * El archivo seleccionado queda disponible en dropzone.file
 */
class ImageDropzone {

    constructor(selector, options = {}) {

        this.container = typeof selector === 'string'
            ? document.querySelector(selector)
            : selector;

        if (!this.container) {
            console.error(`ImageDropzone: no se encontró el elemento "${selector}"`);
            return;
        }

        this.options = {
            maxSizeMB: 5,
            accept: ['image/jpeg', 'image/png', 'image/webp', 'image/gif'],
            ...options
        };

        this.file = null;

        this._build();
        this._bindEvents();
    }

    // ─── Construcción del DOM ────────────────────────────────────────────────

    _build() {

        this.container.classList.add('dropzone');

        // Input oculto (se reutiliza si ya existe)
        this.input = this.container.querySelector('input[type="file"]');
        if (!this.input) {
            this.input = document.createElement('input');
            this.input.type = 'file';
            this.input.name = 'imagen_tapa';
            this.container.appendChild(this.input);
        }
        this.input.accept = this.options.accept.join(',');
        this.input.classList.add('dropzone-input');

        // Área visual
        this.area = document.createElement('div');
        this.area.classList.add('dropzone-area');
        this.area.setAttribute('role', 'button');
        this.area.setAttribute('tabindex', '0');
        this.area.setAttribute('aria-label', 'Área de carga de imagen. Hacé clic o arrastrá una imagen aquí.');

        this.area.innerHTML = `
            <div class="dropzone-icon" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                    <circle cx="8.5" cy="8.5" r="1.5"/>
                    <polyline points="21 15 16 10 5 21"/>
                </svg>
            </div>
            <p class="dropzone-title">Arrastrá la imagen acá</p>
            <p class="dropzone-subtitle">o <span class="dropzone-link">hacé clic para buscarla</span></p>
            <p class="dropzone-hint">JPG, PNG, WEBP — máx. ${this.options.maxSizeMB} MB</p>
        `;

        this.container.appendChild(this.area);

        // Preview (oculta hasta que se cargue algo)
        this.preview = document.createElement('div');
        this.preview.classList.add('dropzone-preview');
        this.preview.hidden = true;
        this.preview.innerHTML = `
            <img class="dropzone-preview-img" src="" alt="Vista previa de la imagen seleccionada">
            <div class="dropzone-preview-info">
                <span class="dropzone-preview-name"></span>
                <span class="dropzone-preview-size"></span>
            </div>
            <button type="button" class="dropzone-remove" aria-label="Quitar imagen seleccionada">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        `;
        this.container.appendChild(this.preview);

        // Mensaje de error
        this.errorMsg = document.createElement('p');
        this.errorMsg.classList.add('dropzone-error');
        this.errorMsg.setAttribute('role', 'alert');
        this.errorMsg.hidden = true;
        this.container.appendChild(this.errorMsg);
    }

    // ─── Eventos ─────────────────────────────────────────────────────────────

    _bindEvents() {

        // Click en el área abre el file picker
        this.area.addEventListener('click', () => this.input.click());
        this.area.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.input.click();
            }
        });

        // Selección por file picker
        this.input.addEventListener('change', () => {
            if (this.input.files && this.input.files[0]) {
                this._handleFile(this.input.files[0]);
            }
        });

        // Drag & Drop
        this.area.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.area.classList.add('dragover');
        });

        this.area.addEventListener('dragleave', (e) => {
            if (!this.area.contains(e.relatedTarget)) {
                this.area.classList.remove('dragover');
            }
        });

        this.area.addEventListener('drop', (e) => {
            e.preventDefault();
            this.area.classList.remove('dragover');
            const file = e.dataTransfer.files[0];
            if (file) this._handleFile(file);
        });

        // Quitar imagen
        this.preview.querySelector('.dropzone-remove').addEventListener('click', () => {
            this.clear();
        });
    }

    // ─── Lógica principal ─────────────────────────────────────────────────────

    _handleFile(file) {

        this._clearError();

        // Validar tipo
        if (!this.options.accept.includes(file.type)) {
            this._showError(`Tipo de archivo no permitido. Usá: ${this.options.accept.map(t => t.split('/')[1].toUpperCase()).join(', ')}.`);
            return;
        }

        // Validar tamaño
        const maxBytes = this.options.maxSizeMB * 1024 * 1024;
        if (file.size > maxBytes) {
            this._showError(`El archivo es demasiado grande. El máximo es ${this.options.maxSizeMB} MB.`);
            return;
        }

        this.file = file;

        // Mostrar preview
        const reader = new FileReader();
        reader.onload = (e) => {
            this.preview.querySelector('.dropzone-preview-img').src = e.target.result;
            this.preview.querySelector('.dropzone-preview-name').textContent = file.name;
            this.preview.querySelector('.dropzone-preview-size').textContent = this._formatSize(file.size);
            this.area.hidden = true;
            this.preview.hidden = false;
        };
        reader.readAsDataURL(file);

        // Disparar evento personalizado
        this.container.dispatchEvent(new CustomEvent('dropzone:change', { detail: { file } }));
    }

    _showError(msg) {
        this.errorMsg.textContent = msg;
        this.errorMsg.hidden = false;
        this.area.classList.add('has-error');
    }

    _clearError() {
        this.errorMsg.hidden = true;
        this.errorMsg.textContent = '';
        this.area.classList.remove('has-error');
    }

    _formatSize(bytes) {
        if (bytes < 1024) return `${bytes} B`;
        if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
        return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
    }

    // ─── API pública ──────────────────────────────────────────────────────────

    /** Limpia la selección y vuelve al estado inicial */
    clear() {
        this.file = null;
        this.input.value = '';
        this.preview.querySelector('.dropzone-preview-img').src = '';
        this.preview.hidden = true;
        this.area.hidden = false;
        this._clearError();
        this.container.dispatchEvent(new CustomEvent('dropzone:clear'));
    }

    /** Devuelve el archivo seleccionado, o null si no hay ninguno */
    getFile() {
        return this.file;
    }
}
