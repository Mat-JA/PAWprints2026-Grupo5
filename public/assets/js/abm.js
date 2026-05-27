/**
 * abm.js
 * Lógica del panel ABM de libros.
 */

// ─── Referencias ──────────────────────────────────────────────────────────────
const panel        = document.getElementById('abm-panel');
const panelTitulo  = document.getElementById('panel-titulo');
const btnNuevo     = document.getElementById('btn-nuevo');
const btnCerrar    = document.getElementById('btn-cerrar-panel');
const btnEliminar  = document.getElementById('btn-eliminar');

const formCrear    = document.getElementById('form-crear');
const formEditar   = document.getElementById('form-editar');
const formEliminar = document.getElementById('form-eliminar');

const editId       = document.getElementById('edit-id');
const eliminarId   = document.getElementById('eliminar-id');

// ─── Dropzones (uno por form) ─────────────────────────────────────────────────
const dropzoneCrear  = new ImageDropzone(formCrear.querySelector('.abm-dropzone'),  { maxSizeMB: 5 });
const dropzoneEditar = new ImageDropzone(formEditar.querySelector('.abm-dropzone'), { maxSizeMB: 5 });

// ─── Abrir panel "Nuevo libro" ────────────────────────────────────────────────
btnNuevo.addEventListener('click', () => {
    panelTitulo.textContent = 'Nuevo libro';
    formCrear.hidden  = false;
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
        formCrear.hidden  = true;
        formEditar.hidden = false;

        // Precargar campos
        editId.value = libro.id;
        setVal(formEditar, 'titulo',      libro.titulo);
        setVal(formEditar, 'isbn',        libro.isbn);
        setVal(formEditar, 'desc_corta',  libro.desc_corta);
        setVal(formEditar, 'descripcion', libro.descripcion);
        setVal(formEditar, 'fecha_pub',   libro.fecha_pub ? libro.fecha_pub.split('T')[0] : '');
        setVal(formEditar, 'precio',      libro.precio);
        setVal(formEditar, 'stock',       libro.stock);

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
}

function setVal(form, name, value) {
    const el = form.querySelector(`[name="${name}"]`);
    if (el) el.value = value ?? '';
}

// ─── Submit con drag & drop ───────────────────────────────────────────────────
[
    { form: formCrear,  getDropzone: () => dropzoneCrear },
    { form: formEditar, getDropzone: () => dropzoneEditar }
].forEach(({ form, getDropzone }) => {
    form.addEventListener('submit', function(e) {
        const dz = getDropzone();
        if (dz && dz.getFile()) {
            e.preventDefault();
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
        }
    });
});
