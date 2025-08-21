@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">


    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h4>Filtrar Reportes</h4>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reports.index') }}" id="filtroForm">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-bold mb-2">Tipo de Actividad</label>
                        <div class="row" id="checkboxContainer">
                            @php
                                $tipos = [
                                    'mantenimiento' => 'Mantenimiento',
                                    'alimentacion' => 'Alimentación',
                                    'humedad' => 'Humedad',
                                    'recoleccion' => 'Recolección',
                                    'ph' => 'PH',
                                    'temperatura' => 'Temperatura'
                                ];
                            @endphp
                            @foreach($tipos as $key => $label)
                                <div class="col-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input tipo-checkbox" type="checkbox" name="tipo[]" value="{{ $key }}"
                                            id="tipo_{{ $key }}"
                                            {{ is_array(request('tipo')) && in_array($key, request('tipo')) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tipo_{{ $key }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="actividadMsg" class="text-danger mt-2" style="display:none;">
                            Debes seleccionar al menos una actividad.
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="worm_bed_id" class="form-label fw-bold mb-2">Cama</label>
                                <select name="worm_bed_id" id="worm_bed_id" class="form-select">
                                    <option value="">Todas las camas</option>
                                    @foreach($beds as $bed)
                                        <option value="{{ $bed->id }}" {{ request('worm_bed_id') == $bed->id ? 'selected' : '' }}>
                                            Cama N° {{ $bed->number }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                       
<div class="col-md-2 d-flex flex-column gap-2">
    <button type="submit" class="btn btn-success w-100" id="filtrarBtn">
        <i class="fas fa-filter me-1"></i> Filtrar
    </button>
    <a href="{{ route('reports.pdf', request()->query()) }}" 
       class="btn btn-danger w-100" 
       role="button" 
       target="_blank" 
       rel="noopener">
       <i class="fas fa-file-pdf me-1"></i> Descargar PDF
    </a>
</div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Listado de Reportes</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Cama</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($actividades as $actividad)
                            <tr>
                                <td>Cama N° {{ $actividad->wormBed->number ?? '-' }}</td>
                                <td>{{ ucfirst($actividad->tipo) }}</td>
                                <td>{{ $actividad->descripcion }}</td>
                                <td>{{ $actividad->fecha_actividad }}</td>
                                <td>{{ $actividad->hora_actividad }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay actividades registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.tipo-checkbox');
    const filtrarBtn = document.getElementById('filtrarBtn');
    const actividadMsg = document.getElementById('actividadMsg');
    const form = document.getElementById('filtroForm');

    function validarCheckboxes() {
        let checked = Array.from(checkboxes).some(cb => cb.checked);
        filtrarBtn.disabled = !checked;
        actividadMsg.style.display = checked ? 'none' : 'block';
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', validarCheckboxes);
    });

    // Validar al cargar la página
    validarCheckboxes();

    // Validar al enviar el formulario
    form.addEventListener('submit', function(e) {
        let checked = Array.from(checkboxes).some(cb => cb.checked);
        if (!checked) {
            e.preventDefault();
            actividadMsg.style.display = 'block';
        }
    });
});
</script>