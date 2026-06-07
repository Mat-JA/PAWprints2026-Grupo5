/**
 * abm.js
 * Lógica del panel ABM de libros.
 */

// ─── Referencias ──────────────────────────────────────────────────────────────
const panel = document.getElementById('abm-panel');
const panelTitulo = document.getElementById('panel-titulo');
const btnNuevo = document.getElementById('btn-nuevo');
const btnCerrar = document.getElementById('btn-cerrar-panel');
const btnEliminar = document.getElementById('btn-eliminar');

const formCrear = document.getElementById('form-crear');
const formEditar = document.getElementById('form-editar');
const formEliminar = document.getElementById('form-eliminar');

const editId = document.getElementById('edit-id');
const eliminarId = document.getElementById('eliminar-id');

// ─── Dropzones (uno por form) ─────────────────────────────────────────────────
const dropzoneCrear = new ImageDropzone(formCrear.querySelector('.abm-dropzone'), { maxSizeMB: 5 });
const dropzoneEditar = new ImageDropzone(formEditar.querySelector('.abm-dropzone'), { maxSizeMB: 5 });

// ─── Abrir panel "Nuevo libro" ────────────────────────────────────────────────
btnNuevo.addEventListener('click', () => {
    panelTitulo.textContent = 'Nuevo libro';
    formCrear.hidden = false;
    formEditar.hidden = true;
    limpiarForm(formCrear);
    dropzoneCrear.clear();
    abrirPanel();
});

// ─── Abrir panel "Editar libro" ───────────────────────────────────────────────
document.querySelectorAll('.abm-btn-editar').forEach(btn => {
    btn.addEventListener('click', () => {
        const libro = JSON.parse(btn.dataset.libro);

        panelTitulo.textContent = 'Editar libro';
        formCrear.hidden = true;
        formEditar.hidden = false;

        // Precargar campos
        editId.value = libro.id;
        setVal(formEditar, 'titulo', libro.titulo);
        setVal(formEditar, 'isbn', libro.isbn);
        setVal(formEditar, 'desc_corta', libro.desc_corta);
        setVal(formEditar, 'descripcion', libro.descripcion);
        setVal(formEditar, 'fecha_pub', libro.fecha_pub ? libro.fecha_pub.split('T')[0] : '');
        setVal(formEditar, 'precio', libro.precio);
        setVal(formEditar, 'stock', libro.stock);

        // Precargar autor
        const autorSelect = formEditar.querySelector('[name="autor_id"]');
        if (autorSelect && libro.autores && libro.autores.length > 0) {
            autorSelect.value = libro.autores[0].id;
        } else if (autorSelect) {
            autorSelect.value = '';
        }

        dropzoneEditar.clear();
        abrirPanel();
    });
});

// ─── Eliminar libro ───────────────────────────────────────────────────────────
btnEliminar.addEventListener('click', () => {
    const titulo = formEditar.querySelector('[name="titulo"]').value;
    if (confirm(`¿Seguro que querés eliminar "${titulo}"? Esta acción no se puede deshacer.`)) {
        eliminarId.value = editId.value;
        formEliminar.submit();
    }
});

// ─── Cerrar panel ─────────────────────────────────────────────────────────────
btnCerrar.addEventListener('click', cerrarPanel);

// ─── Helpers ──────────────────────────────────────────────────────────────────
function abrirPanel() {
    panel.hidden = false;
    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function cerrarPanel() {
    panel.hidden = true;
}

function limpiarForm(form) {
    form.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], input[type="email"], textarea, select').forEach(el => {
        el.value = '';
    });
    limpiarErrores(form);
}

function setVal(form, name, value) {
    const el = form.querySelector(`[name="${name}"]`);
    if (el) el.value = value ?? '';
}

// ─── Reglas de validación ─────────────────────────────────────────────────────

const REGLAS = [
    {
        nombre: 'titulo',
        validar(val) {
            if (val.length < 2) return 'El título debe tener al menos 2 caracteres.';
            if (val.length > 75) return 'El título no puede superar los 75 caracteres.';
            return null;
        }
    },
    {
        nombre: 'isbn',
        validar(val) {
            if (!val) return 'El ISBN es obligatorio.';
            const soloDigitos = val.replace(/[\-\s]/g, '');
            if (!/^\d+$/.test(soloDigitos))
                return 'El ISBN solo puede contener dígitos y guiones.';
            if (soloDigitos.length !== 10 && soloDigitos.length !== 13)
                return 'El ISBN debe tener 10 o 13 dígitos.';
            return null;
        }
    },
    {
        nombre: 'desc_corta',
        validar(val) {
            if (val.length < 5) return 'La descripción corta debe tener al menos 5 caracteres.';
            if (val.length > 150) return 'La descripción corta no puede superar los 150 caracteres.';
            return null;
        }
    },
    {
        nombre: 'descripcion',
        validar(val) {
            if (val.length < 10) return 'La descripción debe tener al menos 10 caracteres.';
            if (val.length > 300) return 'La descripción no puede superar los 300 caracteres.';
            return null;
        }
    },
    {
        nombre: 'fecha_pub',
        validar(val) {
            if (!val) return 'La fecha de publicación es obligatoria.';
            return null;
        }
    },
    {
        nombre: 'precio',
        validar(val) {
            if (val === '') return 'El precio es obligatorio.';
            if (isNaN(val) || Number(val) < 0) return 'El precio debe ser un número mayor o igual a 0.';
            return null;
        }
    },
    {
        nombre: 'stock',
        validar(val) {
            if (val === '') return 'El stock es obligatorio.';
            const n = Number(val);
            if (!Number.isInteger(n) || n < 0) return 'El stock debe ser un entero mayor o igual a 0.';
            return null;
        }
    },
];

// ─── Helpers de validación ────────────────────────────────────────────────────

function limpiarErrores(form) {
    form.querySelectorAll('.abm-campo-error').forEach(el => el.remove());
    form.querySelectorAll('.abm-input--error, .abm-textarea--error').forEach(el => {
        el.classList.remove('abm-input--error', 'abm-textarea--error');
    });
}

function mostrarError(campo, mensaje) {
    const claseError = campo.tagName === 'TEXTAREA' ? 'abm-textarea--error' : 'abm-input--error';
    campo.classList.add(claseError);
    const span = document.createElement('span');
    span.className = 'abm-campo-error';
    span.setAttribute('aria-live', 'polite');
    span.textContent = mensaje;
    campo.insertAdjacentElement('afterend', span);
}

function validarForm(form) {
    limpiarErrores(form);
    let valido = true;

    for (const regla of REGLAS) {
        const campo = form.querySelector(`[name="${regla.nombre}"]`);
        if (!campo) continue;
        const error = regla.validar(campo.value.trim());
        if (error) {
            mostrarError(campo, error);
            if (valido) {
                // Hace foco en el primer campo con error
                campo.scrollIntoView({ behavior: 'smooth', block: 'center' });
                campo.focus({ preventScroll: true });
            }
            valido = false;
        }
    }

    return valido;
}

// Limpia el error de un campo en tiempo real al editarlo
function agregarListenersEnLinea(form) {
    form.querySelectorAll('.abm-input, .abm-textarea').forEach(campo => {
        campo.addEventListener('input', () => {
            campo.classList.remove('abm-input--error', 'abm-textarea--error');
            const siguiente = campo.nextElementSibling;
            if (siguiente && siguiente.classList.contains('abm-campo-error')) {
                siguiente.remove();
            }
        });
    });
}

agregarListenersEnLinea(formCrear);
agregarListenersEnLinea(formEditar);

// ─── Submit con drag & drop ───────────────────────────────────────────────────
[
    { form: formCrear, getDropzone: () => dropzoneCrear },
    { form: formEditar, getDropzone: () => dropzoneEditar }
].forEach(({ form, getDropzone }) => {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!validarForm(form)) return;

        const dz = getDropzone();
        if (dz && dz.getFile()) {
            const formData = new FormData(form);
            formData.set('imagen_tapa', dz.getFile());
            fetch(form.action, {
                method: 'POST',
                body: formData
            }).then(res => {
                if (res.redirected) {
                    window.location.href = res.url;
                } else if (!res.ok) {
                    // Server error: try to extract error param from redirected URL or show generic
                    window.location.href = '/libros/abm?error=' + encodeURIComponent('Error del servidor al procesar la solicitud.');
                }
            }).catch(err => {
                window.location.href = '/libros/abm?error=' + encodeURIComponent('Error de red: no se pudo conectar con el servidor.');
            });
        } else {
            form.submit();
        }
    });
});

// ─── Modal inline: crear autor ────────────────────────────────────────────────
(function () {
    const modalOverlay   = document.getElementById('modal-overlay');
    const modalForm      = document.getElementById('form-inline-autor');
    const modalCerrar    = document.getElementById('btn-cerrar-modal');
    const inlineError    = document.getElementById('inline-error');

    if (!modalOverlay) return;

    function abrirModal() {
        modalForm.reset();
        inlineError.hidden = true;
        inlineError.textContent = '';
        modalOverlay.hidden = false;
        modalForm.querySelector('[name="nombre"]').focus();
    }

    function cerrarModal() {
        modalOverlay.hidden = true;
    }

    // "+" buttons en ambos formularios
    document.querySelectorAll('.abm-btn-inline-autor').forEach(btn => {
        btn.addEventListener('click', abrirModal);
    });

    // Cerrar con el botón ✕
    modalCerrar.addEventListener('click', cerrarModal);

    // Cerrar al clickear fuera del modal
    modalOverlay.addEventListener('click', function (e) {
        if (e.target === modalOverlay) cerrarModal();
    });

    // Submit del modal
    modalForm.addEventListener('submit', function (e) {
        e.preventDefault();

        inlineError.hidden = true;
        inlineError.textContent = '';

        const formData = new FormData(modalForm);

        fetch('/api/autores/crear', {
            method: 'POST',
            body: formData
        }).then(res => res.json()).then(data => {
            if (data.error) {
                inlineError.textContent = data.error;
                inlineError.hidden = false;
                return;
            }

            // Agregar la opción a todos los <select name="autor_id"> y seleccionarla
            document.querySelectorAll('select[name="autor_id"]').forEach(select => {
                const opt = document.createElement('option');
                opt.value = data.id;
                opt.textContent = data.nombre;
                select.appendChild(opt);
                select.value = data.id;
            });

            cerrarModal();
        }).catch(() => {
            inlineError.textContent = 'Error de red al crear el autor.';
            inlineError.hidden = false;
        });
    });
})();

// ─── Open Library: buscar por ISBN o Título ───────────────────────────────────
(function () {
    /**
     * Autocompleta los campos del formulario con los datos de OL.
     */
    function autocompletarForm(form, data) {
        if (data.title) {
            setVal(form, 'titulo', data.title.substring(0, 75));
        }
        if (data.description) {
            setVal(form, 'descripcion', data.description.substring(0, 300));
            setVal(form, 'desc_corta', data.description.substring(0, 150));
        }
        if (data.publish_date) {
            setVal(form, 'fecha_pub', data.publish_date);
        }
        // Si la búsqueda devolvió ISBN y el campo está vacío, precargarlo
        if (data.isbn) {
            const isbnField = form.querySelector('[name="isbn"]');
            if (isbnField && !isbnField.value.trim()) {
                setVal(form, 'isbn', data.isbn.substring(0, 20));
            }
        }
        // Intentar seleccionar autor
        if (data.author_name && form.querySelector('[name="autor_id"]')) {
            const autorSelect = form.querySelector('[name="autor_id"]');
            const autorNombre = data.author_name.split(',')[0].trim();
            for (const opt of autorSelect.options) {
                if (opt.textContent.toLowerCase() === autorNombre.toLowerCase()) {
                    autorSelect.value = opt.value;
                    return;
                }
            }
        }
    }

    /**
     * Busca en OL y autocompleta usando la URL construida.
     */
    function buscarYAutocompletar(btn, url) {
        const form = btn.closest('form');
        if (!form) return;

        const originalText = btn.textContent;
        btn.textContent = '⏳';
        btn.classList.add('abm-btn-buscar--loading');
        btn.disabled = true;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    alert('No se encontró información: ' + data.error);
                    return;
                }
                autocompletarForm(form, data);
            })
            .catch(() => {
                alert('Error de red al consultar Open Library.');
            })
            .finally(() => {
                btn.textContent = originalText;
                btn.classList.remove('abm-btn-buscar--loading');
                btn.disabled = false;
            });
    }

    // Buscar por ISBN (botón junto al campo isbn)
    document.querySelectorAll('.abm-btn-buscar:not(.abm-btn-buscar--titulo)').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = btn.closest('form');
            if (!form) return;

            const isbnInput = form.querySelector('[name="isbn"]');
            if (!isbnInput) return;

            const isbn = isbnInput.value.replace(/[\-\s]/g, '').trim();
            if (!isbn) {
                alert('Por favor ingresá un ISBN primero.');
                return;
            }

            buscarYAutocompletar(btn, '/api/libros/buscar?isbn=' + encodeURIComponent(isbn));
        });
    });

    // Buscar por Título (botón junto al campo titulo)
    document.querySelectorAll('.abm-btn-buscar--titulo').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = btn.closest('form');
            if (!form) return;

            const tituloInput = form.querySelector('[name="titulo"]');
            if (!tituloInput) return;

            const titulo = tituloInput.value.trim();
            if (!titulo || titulo.length < 2) {
                alert('Por favor ingresá un título de al menos 2 caracteres.');
                return;
            }

            buscarYAutocompletar(btn, '/api/libros/buscar?titulo=' + encodeURIComponent(titulo));
        });
    });
})();