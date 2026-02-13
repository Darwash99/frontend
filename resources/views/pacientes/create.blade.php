<div class="modal fade" id="modalPaciente" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Paciente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formPaciente" onsubmit="event.preventDefault(); guardarPaciente();">
        @csrf
        <div class="modal-body">
          <div class="row g-3">
            
            <div class="col-md-6">
              <label class="form-label">Tipo de Documento</label>
              <select name="tipo_documento_id" id="tipo_documento_id" class="form-select" >
                <option value="">Seleccione...</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Número de Documento</label>
              <input type="number" name="numero_documento" class="form-control" >
            </div>

            <div class="col-md-6">
              <label class="form-label">Primer Nombre</label>
              <input type="text" name="nombre1" class="form-control" >
            </div>
            <div class="col-md-6">
              <label class="form-label">Segundo Nombre</label>
              <input type="text" name="nombre2" class="form-control">
            </div>

            <div class="col-md-6">
              <label class="form-label">Primer Apellido</label>
              <input type="text" name="apellido1" class="form-control" >
            </div>
            <div class="col-md-6">
              <label class="form-label">Segundo Apellido</label>
              <input type="text" name="apellido2" class="form-control">
            </div>

            <div class="col-md-12">
              <label class="form-label">Género</label>
              <select name="genero_id" id="genero_id" class="form-select" >
                <option value="">Seleccione...</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Departamento</label>
              <select name="departamento_id"  id="dep-select" class="form-select" >
                <option value="">Seleccione...</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Municipio</label>
              <select name="municipio_id" id="mun-select" class="form-select" >
                <option value="">Seleccione...</option>
              </select>
            </div>

            <div class="col-md-12">
              <label class="form-label">Correo Electrónico</label>
              <input type="email" name="correo" class="form-control">
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary" id="btnGuardar">
            <span class="spinner-border spinner-border-sm d-none" id="btnGuardarSpinner" role="status"></span>
            <span id="btnGuardarText">Guardar Paciente</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>