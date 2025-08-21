
@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1 class="text-center mb-4">Bienvenido al lombricultivo</h1>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
        @forelse ($camas as $cama)
            <div class="col">
                <div class="card shadow-lg h-100
                    {{ $cama->status == 'Disponible' ? 'border-start border-4 border-success' : 
                       ($cama->status == 'Ocupada' ? 'border-start border-4 border-warning' : 'border-start border-4 border-danger') }}">
                    @if (isset($cama->alerts_count) && $cama->alerts_count > 0)
                        <span class="position-absolute top-0 end-0 badge bg-danger rounded-pill m-2">
                            {{ $cama->alerts_count }}
                        </span>
                    @endif

                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ asset('imgLombri/lombriz4welcome.png') }}" alt="Lombriz" class="me-3" style="width: 40px; height: 40px; object-fit: contain;">
                            <div>
                                <h5 class="card-title mb-1">Cama {{ $cama->number }}</h5>
                                <p class="card-text mb-1">Estado: 
                                    <span class="{{ $cama->status == 'Disponible' ? 'text-success' : 
                                                    ($cama->status == 'Ocupada' ? 'text-warning' : 'text-danger') }}">
                                        {{ $cama->status }}
                                    </span>
                                </p>
                                <p class="card-text">Inicio: {{ \Carbon\Carbon::parse($cama->start_date)->format('d/m/Y') }}</p>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-success flex-fill" onclick="showActivityModal({{ $cama->id }}, {{ $cama->number }})">
                                <i class="fas fa-plus"></i> Actividad
                            </button>
                            <button class="btn btn-primary flex-fill" onclick="openAlertsModal({{ $cama->id }}, {{ $cama->number }})">
                                <i class="fas fa-bell"></i> Alertas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center text-muted">No hay camas registradas. Agrega una cama para empezar.</p>
            </div>
        @endforelse
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('lombrisoft.admin.camas.create') }}" class="btn btn-success">Agregar Nueva Cama</a>
    </div>

    <!-- Modal Crear Actividad -->
    <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel">Registrar Actividad en Cama <span id="modalBedNumber"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('lombrisoft.admin.bed_activities.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="worm_bed_id" id="modalBedId">

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de Actividad</label>
                            <select class="form-select" id="tipo" name="tipo" required onchange="toggleFields()">
                                <option value="" disabled selected>Seleccione un tipo</option>
                                <option value="mantenimiento">Mantenimiento</option>
                                <option value="alimentacion">Alimentación</option>
                                <option value="humedad">Humedad</option>
                                <option value="recoleccion">Recolección</option>
                                <option value="ph">pH</option>
                                <option value="temperatura">Temperatura</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>

                        <div class="mb-3" id="cantidad_alimento_section" style="display: none;">
                            <label for="cantidad_alimento" class="form-label">Cantidad de Alimento (kg)</label>
                            <input type="number" class="form-control" id="cantidad_alimento" name="cantidad_alimento" min="1">
                            <label for="tipo_alimento" class="form-label">Tipo de Alimento</label>
                            <input type="text" class="form-control" id="tipo_alimento" name="tipo_alimento">
                        </div>

                        <div class="mb-3" id="nivel_humedad_section" style="display: none;">
                            <label for="nivel_humedad" class="form-label">Nivel de Humedad (%)</label>
                            <input type="number" step="0.1" class="form-control" id="nivel_humedad" name="nivel_humedad" min="0" max="100">
                        </div>

                        <div class="mb-3" id="cantidad_recolectada_section" style="display: none;">
                            <label for="cantidad_recolectada" class="form-label">Cantidad Recolectada</label>
                            <input type="number" class="form-control" id="cantidad_recolectada" name="cantidad_recolectada" min="1">
                            <label for="tipo_recoleccion" class="form-label">Tipo de Recolección</label>
                            <select class="form-select" id="tipo_recoleccion" name="tipo_recoleccion">
                                <option value="" selected disabled>Seleccione tipo de recolección</option>
                                <option value="humus">Humus</option>
                                <option value="lixiviado">Lixiviado</option>
                            </select>
                        </div>

                        <div class="mb-3" id="ph_section" style="display: none;">
                            <label for="ph" class="form-label">Nivel de pH</label>
                            <input type="number" step="0.1" class="form-control" id="ph" name="ph" min="0" max="14">
                        </div>

                        <div class="mb-3" id="temperatura_section" style="display: none;">
                            <label for="temperatura" class="form-label">Temperatura (°C)</label>
                            <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" min="-50" max="100">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_actividad" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_actividad" name="fecha_actividad" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hora_actividad" class="form-label">Hora</label>
                                <input type="time" class="form-control" id="hora_actividad" name="hora_actividad" required>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Ver Alertas -->
    <div class="modal fade" id="alertsModal" tabindex="-1" aria-labelledby="alertsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertsModalLabel">Alertas de la cama <span id="alertsBedNumber"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertsList" class="d-flex flex-column gap-2"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tipoActividad = document.getElementById('tipo');
    const fechaInput = document.getElementById('fecha_actividad');
    const horaInput = document.getElementById('hora_actividad');

    // Automatic date and time population
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const formattedDate = `${year}-${month}-${day}`;
    fechaInput.value = formattedDate;

    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const formattedTime = `${hours}:${minutes}`;
    horaInput.value = formattedTime;

    function toggleFields() {
        const tipo = tipoActividad.value;
        document.getElementById('cantidad_alimento_section').style.display = 'none';
        document.getElementById('nivel_humedad_section').style.display = 'none';
        document.getElementById('cantidad_recolectada_section').style.display = 'none';
        document.getElementById('ph_section').style.display = 'none';
        document.getElementById('temperatura_section').style.display = 'none';

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

    tipoActividad.addEventListener('change', toggleFields);
    toggleFields();

    window.showActivityModal = function(bedId, bedNumber) {
        document.getElementById('modalBedId').value = bedId;
        document.getElementById('modalBedNumber').innerText = bedNumber;
        const modal = new bootstrap.Modal(document.getElementById('activityModal'));
        modal.show();
    };

    window.openAlertsModal = function(bedId, bedNumber) {
        document.getElementById('alertsBedNumber').innerText = bedNumber;
        let alerts = @json($camas);
        let cama = alerts.find(c => c.id === bedId);
        let container = document.getElementById('alertsList');
        container.innerHTML = '';

        if (cama.activity_alerts && cama.activity_alerts.length > 0) {
            cama.activity_alerts.forEach(al => {
                container.innerHTML += `
                    <div class="border p-2 rounded">
                        <strong>Tipo:</strong> ${al.activity_type} <br>
                        <strong>Frecuencia:</strong> ${al.frequency_days} días
                    </div>
                `;
            });
        } else {
            container.innerHTML = '<p class="text-muted text-center">No tiene alertas.</p>';
        }

        const modal = new bootstrap.Modal(document.getElementById('alertsModal'));
        modal.show();
    };
});
</script>
@endsection