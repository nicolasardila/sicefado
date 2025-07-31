@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Error!</strong> Por favor revisa los campos.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg rounded">
        <div class="card-header bg-primary text-white text-center">
            <h4>Registrar Nueva Actividad</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('lombrisoft.admin.bed_activities.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="worm_bed_id" class="form-label">Cama</label>
                    <select class="form-select" id="worm_bed_id" name="worm_bed_id" required>
                        <option value="" disabled selected>Seleccione una cama</option>
                        @foreach ($camas as $cama)
                            <option value="{{ $cama->id }}">Cama N° {{ $cama->number }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de Actividad</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="" disabled selected>Seleccione un tipo</option>
                        <option value="mantenimiento">Mantenimiento</option>
                        <option value="alimentacion">Alimentación</option>
                        <option value="humedad">Humedad</option>
                        <option value="recoleccion">Recolección</option>
                        <option value="ph">ph</option>
                        <option value="temperatura">Temperatura</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha_actividad" class="form-label">Fecha de Actividad</label>
                    <input type="date" class="form-control" id="fecha_actividad" name="fecha_actividad" required>
                </div>

                <div class="mb-3">
                    <label for="hora_actividad" class="form-label">Hora de Actividad</label>
                    <input type="time" class="form-control" id="hora_actividad" name="hora_actividad">
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2"></textarea>
                </div>

                {{-- Sección alimentación --}}
                <div class="mb-3" id="cantidad_alimento_section" style="display: none;">
                    <label for="cantidad_alimento" class="form-label">Cantidad de Alimento (kg)</label>
                    <input type="number" class="form-control" id="cantidad_alimento" name="cantidad_alimento" min="1">
                    <label for="tipo_alimento" class="form-label">Tipo De Alimento</label>
                    <input type="text" class="form-control" id="tipo_alimento" name="tipo_alimento" min="1">
                </div>

                {{-- Sección humedad --}}
                <div class="mb-3" id="nivel_humedad_section" style="display: none;">
                    <label for="nivel_humedad" class="form-label">Nivel de Humedad (%)</label>
                    <input type="number" step="0.1" class="form-control" id="nivel_humedad" name="nivel_humedad" min="0" max="100">
                </div>

                {{-- Sección recolección --}}
                <div class="mb-3" id="cantidad_recolectada_section" style="display: none;">
                    <label for="cantidad_recolectada" class="form-label">Cantidad Recolectada</label>
                    <input type="number" class="form-control" id="cantidad_recolectada" name="cantidad_recolectada" min="1">
                    <label for="tipo_recoleccion" class="form-label">Tipo Recoleccion</label>
                    <select class="form-select" id="tipo_recoleccion" name="tipo_recoleccion">
                        <option value="" selected disabled>Seleccione tipo de recolección</option>
                        <option value="humus">Humus</option>
                        <option value="lixiviado">Lixiviado</option>
                    </select>
                </div>
                
                {{-- Sección PH --}}
                <div class="mb-3" id="ph_section" style="display: none;">
                    <label for="ph" class="form-label">Nivel de pH</label>
                    <input type="number" step="0.1" class="form-control" id="ph" name="ph" min="0" max="14">
                </div>
                {{-- Sección Temperatura --}}
                <div class="mb-3" id="temperatura_section" style="display: none;">
                    <label for="temperatura" class="form-label">Temperatura (°C)</label>
                    <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" min="-50" max="100">
                </div>


                <div class="text-center">
                    <button type="submit" class="btn btn-success">Registrar</button>
                    <a href="{{ route('lombrisoft.admin.bed_activities.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tipoActividad = document.getElementById('tipo');

    function toggleSections() {
        const tipo = tipoActividad.value;

        // Ocultar todas las secciones primero
        document.getElementById('cantidad_alimento_section').style.display = 'none';
        document.getElementById('nivel_humedad_section').style.display = 'none';
        document.getElementById('cantidad_recolectada_section').style.display = 'none';
        document.getElementById('ph_section').style.display = 'none';
        document.getElementById('temperatura_section').style.display = 'none';

        // Mostrar solo la sección correspondiente
        switch (tipo) {
            case 'alimentacion':
                document.getElementById('cantidad_alimento_section').style.display = 'block';
                break;
            case 'humedad':
                document.getElementById('nivel_humedad_section').style.display = 'block';
                break;
            case 'recoleccion':
                document.getElementById('cantidad_recolectada_section').style.display = 'block';
                break;
            case 'ph':
                document.getElementById('ph_section').style.display = 'block';
                break;
            case 'temperatura':
                document.getElementById('temperatura_section').style.display = 'block';
                break;
        }
    }
        // Fecha y hora automática
    const fechaInput = document.getElementById('fecha_actividad');
    const horaInput = document.getElementById('hora_actividad');

    const now = new Date();

    // Formatear fecha: YYYY-MM-DD
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0'); // Los meses van de 0 a 11
    const day = String(now.getDate()).padStart(2, '0');
    const formattedDate = `${year}-${month}-${day}`;
    fechaInput.value = formattedDate;

    // Formatear hora: HH:MM
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const formattedTime = `${hours}:${minutes}`;
    horaInput.value = formattedTime;

    // Al cambiar el tipo de actividad
    tipoActividad.addEventListener('change', toggleSections);

    // Ejecutar al cargar por si hay un valor preseleccionado
    toggleSections();
});
</script>
@endsection
