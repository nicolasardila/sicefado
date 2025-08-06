@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4">Registrar Nueva Actividad</h3>

    <form action="{{ route('lombrisoft.activitys.store') }}" method="POST">
        @csrf

        {{-- Tipo de Actividad --}}
        <div class="mb-3">
            <label for="tipo_actividad" class="form-label">Tipo de Actividad</label>
            <select class="form-select" id="tipo_actividad" name="tipo_actividad" required>
                <option value="" disabled selected>Seleccione una actividad</option>
                <option value="alimentacion">Alimentación</option>
                <option value="humedad">Control de Humedad</option>
                <option value="mantenimiento">Mantenimiento</option>
                <option value="recoleccion">Recolección</option>
            </select>
        </div>

        {{-- Contenedor donde se cargará el formulario dinámico --}}
        <div id="formulario_dinamico"></div>

        <button type="submit" class="btn btn-success mt-3">Guardar Actividad</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const tipoActividad = document.getElementById('tipo_actividad');
    const contenedor = document.getElementById('formulario_dinamico');

    tipoActividad.addEventListener('change', () => {
        const tipo = tipoActividad.value;
        let html = '';

        switch (tipo) {
            case 'alimentacion':
                html = `
                    <div class="mb-3">
                        <label class="form-label">Cama</label>
                        <select name="worm_bed_id" class="form-select" required>
                            @foreach($camas as $cama)
                                <option value="{{ $cama->id }}">{{ $cama->number }} - {{ $cama->status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de Alimento</label>
                        <select name="tipo_alimento" class="form-select" required>
                            <option value="Restos vegetales">Restos vegetales</option>
                            <option value="Estiércol bovino">Estiércol bovino</option>
                            <option value="Pulpa de café">Pulpa de café</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cantidad (kg)</label>
                        <input type="number" name="cantidad" step="0.01" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" class="form-control" maxlength="500"></textarea>
                    </div>
                `;
                break;

            case 'humedad':
                html = `
                    <div class="mb-3">
                        <label class="form-label">Cama</label>
                        <select name="worm_bed_id" class="form-select" required>
                            @foreach($camas as $cama)
                                <option value="{{ $cama->id }}">{{ $cama->number }} - {{ $cama->status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" class="form-control" maxlength="500" required></textarea>
                    </div>
                `;
                break;

            case 'mantenimiento':
                html = `
                    <div class="mb-3">
                        <label class="form-label">Cama</label>
                        <select name="worm_bed_id" class="form-select" required>
                            @foreach($camas as $cama)
                                <option value="{{ $cama->id }}">{{ $cama->number }} - {{ $cama->status }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tipo de Mantenimiento</label>
                        <select name="tipo_mantenimiento" class="form-select" required>
                            <option value="Limpieza">Limpieza</option>
                            <option value="Reparación">Reparación</option>
                            <option value="Desinfección">Desinfección</option>
                            <option value="Otros">Otros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" minlength="20" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Herramientas Utilizadas</label>
                        <select name="herramientas[]" class="form-select" multiple required>
                            @foreach($herramientas as $herramienta)
                                <option value="{{ $herramienta->id }}">{{ $herramienta->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                `;
                break;

            case 'recoleccion':
                html = `
                    <div class="mb-3">
                        <label class="form-label">Producto</label>
                        <div>
                            <input type="radio" name="producto" value="Humus" required> Humus
                            <input type="radio" name="producto" value="Lixiviado" required> Lixiviado
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cantidad (kg o litros)</label>
                        <input type="number" name="cantidad" step="0.01" class="form-control" required>
                    </div>
                `;
                break;
        }

        contenedor.innerHTML = html;
    });
});
</script>
@endsection
