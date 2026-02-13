@extends('layouts.app')

@section('title', 'Pacientes')

@section('content')

<h2>Listado de Pacientes</h2>

<div class="card mt-3">
    <div class="card-body">
        {{-- Crear Paciente --}}
        <button class="btn btn-primary mb-3" onclick="openModal()">
            <i class="bi bi-plus"></i> Nuevo Paciente
        </button>

        <!-- Campo y filtro buscar -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="searchInput" 
                    class="form-control" 
                    placeholder="Buscar por nombre o correo">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-20" onclick="cargarPacientes(1);">
                    <i class="bi bi-funnel"></i>
                </button>
                <button class="btn btn-danger w-20" onclick="EliminarFiltro();">
                    <i class="bi bi-trash"></i> 
                </button>
            </div>
        </div>

        <!-- Tabla Listar Paciente -->
        <table class="table table-bordered" id="TablePaciente">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre y Apellidos</th>
                    <th>Correo</th>
                    <th>Identificación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        
        <!-- Paginación -->
        <div id="paginacion" class="d-flex flex-wrap align-items-center gap-1 mt-3"></div>

        <!-- Modal Crear Paciente -->
        @include('pacientes.create')
    </div>
</div>
@include('pacientes.moda-eliminar')

@endsection

@push('scripts')
    <script src="{{ asset('js/paciente.js') }}"></script>
    <script>
        const API_URL = "{{ env('API_URL') }}";
        const TOKEN = "{{ session('token') }}";
        let pacienteIdAEliminar = null;
        let pacienteIdEditar = null;
        let paginaActual = 1;
        const limit = 10;

    </script>

@endpush
