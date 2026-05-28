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
    form.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], input[type="email"], textarea').forEach(el => {
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
                }
            });
        } else {
            form.submit();
        }
    });
});