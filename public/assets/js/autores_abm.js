/**
 * autores_abm.js
 * Lógica del panel ABM de autores.
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

// ─── Abrir panel "Nuevo autor" ────────────────────────────────────────────────
btnNuevo.addEventListener('click', () => {
    panelTitulo.textContent = 'Nuevo autor';
    formCrear.hidden = false;
    formEditar.hidden = true;
    limpiarForm(formCrear);
    abrirPanel();
});

// ─── Abrir panel "Editar autor" ───────────────────────────────────────────────
document.querySelectorAll('.abm-btn-editar').forEach(btn => {
    btn.addEventListener('click', () => {
        const autor = JSON.parse(btn.dataset.autor);

        panelTitulo.textContent = 'Editar autor';
        formCrear.hidden = true;
        formEditar.hidden = false;

        editId.value = autor.id;
        setVal(formEditar, 'nombre', autor.nombre);
        setVal(formEditar, 'bio', autor.bio);

        abrirPanel();
    });
});

// ─── Eliminar autor ───────────────────────────────────────────────────────────
btnEliminar.addEventListener('click', () => {
    const nombre = formEditar.querySelector('[name="nombre"]').value;
    if (confirm(`¿Seguro que querés eliminar a "${nombre}"? Esta acción no se puede deshacer.`)) {
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
    form.querySelectorAll('input[type="text"], input[type="number"], textarea, select').forEach(el => {
        el.value = '';
    });
}

function setVal(form, name, value) {
    const el = form.querySelector(`[name="${name}"]`);
    if (el) el.value = value ?? '';
}
