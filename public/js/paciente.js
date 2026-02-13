//cargar los selects de los modales crear y editar paciente
async function cargarSelectsModals() {
    try {
        const headers = { 'Authorization': 'Bearer ' + TOKEN };

        // Realizamos las peticiones en paralelo para mayor velocidad
        const [resDocs, resGeneros, resDeps] = await Promise.all([
            fetch(API_URL + '/tipodocumento', { headers }),
            fetch(API_URL + '/generos', { headers }),
            fetch(API_URL + '/departamentos', { headers })
        ]);

        const tiposDoc = await resDocs.json();
        const generos = await resGeneros.json();
        const departamentos = await resDeps.json();

        // Llenar Tipo Documento
        const selectDoc = document.getElementById('tipo_documento_id');
        selectDoc.innerHTML = '<option value="">Seleccione Tipo Documento...</option>';

        tiposDoc.forEach(item => {
            selectDoc.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
        });

        // Llenar Géneros
        const selectGen = document.getElementById('genero_id');
        selectGen.innerHTML = '<option value="">Seleccione Género...</option>';
        generos.forEach(item => {
            selectGen.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
        });

        // Llenar Departamentos
        const selectDep = document.getElementById('dep-select');
        selectDep.innerHTML = '<option value="">Seleccione Departamento...</option>';
        departamentos.forEach(item => {
            selectDep.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
        });

    } catch (error) {
        console.error("Error cargando selects:", error);
        showToast("Error al inicializar formularios", "danger");
    }
}

//Renderizar tabla de pacientes
function renderizarTabla(pacientes) {
    const tbody = document.querySelector("#TablePaciente tbody");
    tbody.innerHTML = '';

    pacientes.forEach((p, index) => {
        tbody.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${p.nombre1} ${p.apellido1}</td>
                <td>${p.correo}</td>
                <td>${p.numero_documento}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editPatient(${p.id})">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="confirmDelete(${p.id})">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;
    });
}

//Renderizar paginación
function renderizarPaginacion(total, page, limit) {
    page = Number(page);
    limit = Number(limit);
    total = Number(total);
    //Calcular total de páginas, si da decimal lo aproximamos hacia arriba con Math.ceil
    const totalPages = Math.ceil(total / limit);
    const container = document.getElementById("paginacion");

    if (!container) {
        console.error("No existe el div #paginacion");
        return;
    }

    container.innerHTML = '';

    if (totalPages <= 1) {
        console.log("Solo hay una página");
        return;
    }

    const maxVisible = 5;//maximo de botones de pagina a mostrar
    let start = Math.max(1, page - Math.floor(maxVisible / 2));
    let end = start + maxVisible - 1;

    if (end > totalPages) {
        end = totalPages;
        start = Math.max(1, end - maxVisible + 1);
    }

    // 🔹 Anterior
    container.innerHTML += `
        <button class="btn btn-sm btn-outline-secondary me-1"
            ${page === 1 ? 'disabled' : ''}
            onclick="cargarPacientes(${page - 1})">
            «
        </button>
    `;

    // 🔹 Números
    for (let i = start; i <= end; i++) {
        container.innerHTML += `
            <button class="btn btn-sm ${i === page ? 'btn-primary' : 'btn-outline-primary'} me-1"
                onclick="cargarPacientes(${i})">
                ${i}
            </button>
        `;
    }

    // 🔹 Siguiente
    container.innerHTML += `
        <button class="btn btn-sm btn-outline-secondary"
            ${page === totalPages ? 'disabled' : ''}
            onclick="cargarPacientes(${page + 1})">
            »
        </button>
    `;

    const inicio = (page - 1) * limit + 1;
    const fin = Math.min(page * limit, total);

    container.innerHTML += `
        <div class="mt-2 text-muted small">
            Mostrando ${inicio} - ${fin} de ${total} registros
        </div>
    `;
}


//Cargar Pacientes
async function cargarPacientes(page = 1) {
    paginaActual = page;
    const buscar = document.getElementById("searchInput").value;
    try {
        const response = await fetch(
            `${API_URL}/pacientes?buscar=${buscar}&pagina=${page}&limit=${limit}`,
            {
                headers: { 'Authorization': 'Bearer ' + TOKEN }
            }
        );

        if (!response.ok) throw new Error();

        const result = await response.json();
        renderizarTabla(result.data);
        renderizarPaginacion(result.total, result.pagina, result.limit);
    } catch(error) {
        showToast("Error cargando pacientes", "danger");
    }
}

//Confirmar eliminación de paciente
document.getElementById("btnConfirmDelete").addEventListener("click", async function () {
    if (!pacienteIdAEliminar) return;
    try {
        const response = await fetch(
            API_URL + '/pacientes/' + pacienteIdAEliminar,
            {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + TOKEN
                }
            }
        );
        if (!response.ok) throw new Error();
        showToast("Paciente eliminado correctamente", "success", 5000);
        bootstrap.Modal.getInstance(
            document.getElementById('modalDelete')
        ).hide();
        cargarPacientes();
    } catch {
        showToast("Error al eliminar paciente", "danger");
    } finally {
        pacienteIdAEliminar = null;
    }
});

//validar si hay errores en el formulario, si los hay se marca el input con un borde rojo y se muestra un mensaje de error debajo del input
function hayErrores(data,form) {
    let hayErrores = false;

    // 🔹 Validaciones
    const requeridos = [
        "tipo_documento_id",
        "numero_documento",
        "nombre1",
        "apellido1",
        "genero_id",
        "departamento_id",
        "municipio_id",
        "correo"
    ];

    requeridos.forEach(campo => {
        const input = form.querySelector(`[name="${campo}"]`);

        if (!data[campo]) {
            marcarError(input, "Este campo es obligatorio");
            hayErrores = true;
        }
    });

    // 🔹 Validar correo si existe
    if (data.correo) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const inputEmail = form.querySelector(`[name="correo"]`);

        if (!emailRegex.test(data.correo)) {
            marcarError(inputEmail, "Correo inválido");
            hayErrores = true;
        }
    }

    // 🔹 Validar número documento
    if (data.numero_documento && data.numero_documento.length < 5) {
        const inputDoc = form.querySelector(`[name="numero_documento"]`);
        marcarError(inputDoc, "Documento demasiado corto");
        hayErrores = true;
    }

    if (hayErrores) {
        showToast("Por favor corrige los campos marcados", "warning");
        return true;
    }

    return false;
}

//Guardar paciente (crear o editar)
async function guardarPaciente() {

    const form = document.getElementById("formPaciente");
    limpiarErrores(form);

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    if(hayErrores(data, form)) return;
    
    const btnText = document.getElementById("btnGuardarText");
    const spinner = document.getElementById("btnGuardarSpinner");

    btnText.textContent = "Guardando...";
    spinner.classList.remove("d-none");

    const url = pacienteIdEditar ? API_URL + '/pacientes/' + pacienteIdEditar : API_URL + '/pacientes';
    try {
        const response = await fetch(url, {
            method: pacienteIdEditar ? 'PUT' : 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + TOKEN
            },
            body: JSON.stringify(data)
        });

        if (!response.ok) throw new Error();

        showToast(pacienteIdEditar ? "Paciente actualizado correctamente" : "Paciente registrado correctamente", "success", 5000);

        form.reset();

        bootstrap.Modal.getInstance(
            document.getElementById('modalPaciente')
        ).hide();

        cargarPacientes();

    } catch (error) {
        showToast("Error al registrar paciente", "danger");
    } finally {
        btnText.textContent = "Guardar Paciente";
        spinner.classList.add("d-none");
        pacienteIdEditar = null;
        document.querySelector("#modalPaciente .modal-title").textContent = "Registrar Nuevo Paciente";
    }
}


//Editar paciente
async function editPatient(id) {
    pacienteIdEditar = id;

    try {
        const response = await fetch(API_URL + '/pacientes/' + id, {
            headers: {
                'Authorization': 'Bearer ' + TOKEN
            }
        });

        if (!response.ok) throw new Error();

        const paciente = await response.json();
        const form = document.getElementById("formPaciente");

        await cargarSelectsModals();

        // 🔹 Llenar campos
        form.nombre1.value = paciente[0].nombre1 || '';
        form.nombre2.value = paciente[0].nombre2 || '';
        form.apellido1.value = paciente[0].apellido1 || '';
        form.apellido2.value = paciente[0].apellido2 || '';
        form.numero_documento.value = paciente[0].numero_documento || '';
        form.correo.value = paciente[0].correo || '';
        form.tipo_documento_id.value = paciente[0].tipo_documento_id || '';
        form.genero_id.value = paciente[0].genero_id || '';
        form.departamento_id.value = paciente[0].departamento_id || '';

        // 🔹 Cargar municipios según departamento
        await cargarMunicipios(paciente[0].departamento_id);
        form.municipio_id.value = paciente[0].municipio_id || '';

        // 🔹 Cambiar título modal
        document.querySelector("#modalPaciente .modal-title")
            .textContent = "Editar Paciente";

        const modal = new bootstrap.Modal(
            document.getElementById('modalPaciente')
        );

        modal.show();

    } catch (error) {
        showToast("Error al cargar datos del paciente: " + error.message, "danger");
    }
}

//cargar municipios según departamento seleccionado
async function cargarMunicipios(departamentoId) {
    const selectMun = document.getElementById('mun-select');

    if (!departamentoId) {
        selectMun.innerHTML = '<option value="">Seleccione Municipio...</option>';
        return;
    }

    try {
        const response = await fetch(`${API_URL}/municipios/${departamentoId}`, {
            headers: {
                'Authorization': 'Bearer ' + TOKEN
            }
        });

        if (!response.ok) throw new Error();

        const municipios = await response.json();

        selectMun.innerHTML = '<option value="">Seleccione Municipio...</option>';

        municipios.forEach(m => {
            selectMun.innerHTML += `<option value="${m.id}">${m.nombre}</option>`;
        });

    } catch {
        showToast("Error cargando municipios", "danger");
    }
}


//cuando se cargue la pagina, ejecutar la funcion cargarPacientes
document.addEventListener("DOMContentLoaded", () => cargarPacientes(1));

//eliminar filtro
function EliminarFiltro() {
    document.getElementById("searchInput").value = '';
    cargarPacientes(1);
}

//actualizar municipio por departamento
document.getElementById('dep-select')
.addEventListener('change', function() {
    cargarMunicipios(this.value);
});

//abrir modal crear paciente
function openModal() {
    const modal = new bootstrap.Modal(document.getElementById('modalPaciente'));
    cargarSelectsModals();
    modal.show();
}

//Marcar campo con error y mostrar mensaje
function marcarError(input, mensaje) {
    input.classList.add("is-invalid");

    let feedback = input.parentElement.querySelector(".invalid-feedback");

    if (!feedback) {
        feedback = document.createElement("div");
        feedback.classList.add("invalid-feedback");
        input.parentElement.appendChild(feedback);
    }
    feedback.textContent = mensaje;
}

//Confirmar eliminación de paciente
function confirmDelete(id) {
    pacienteIdAEliminar = id;

    const modal = new bootstrap.Modal(
        document.getElementById('modalDelete')
    );

    modal.show();
}

//limpiar errores
function limpiarErrores(form) {
    form.querySelectorAll(".is-invalid").forEach(el => {
        el.classList.remove("is-invalid");
    });

    form.querySelectorAll(".invalid-feedback").forEach(el => {
        el.remove();
    });
}
