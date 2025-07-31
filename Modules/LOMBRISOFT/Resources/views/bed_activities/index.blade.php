@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">
    <div class="mb-3 text-end">
        <a href="{{ route('lombrisoft.admin.bed_activities.create') }}" class="btn btn-primary">Registrar Nueva Actividad</a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    @endif

    @if ($activities->isEmpty())
    <div class="alert alert-info text-center">No hay actividades registradas.</div>
    @else
    <div class="card shadow-lg rounded">
        <div class="card-header bg-success text-white text-center">
            <h4>Listado de Actividades</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Cama</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                        <tr>
                            <td>Cama N° {{ $activity->wormBed->number }}</td>
                            <td>{{ ucfirst($activity->tipo) }}</td>
                            <td>{{ $activity->fecha_actividad }}</td>
                            <td>{{ $activity->hora_actividad ?? '-' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editModal"
                                    data-id="{{ $activity->id }}"
                                    data-tipo="{{ $activity->tipo }}"
                                    data-cama="{{ $activity->worm_bed_id }}"
                                    data-fecha="{{ $activity->fecha_actividad }}"
                                    data-hora="{{ $activity->hora_actividad }}">
                                    Editar
                                </button>
                                <form action="{{ route('lombrisoft.admin.bed_activities.destroy', $activity->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmarEliminacion(this)">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Actividad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="editWormBed" class="form-label">Cama</label>
                        <select class="form-select" id="editWormBed" name="worm_bed_id" required>
                            @foreach ($camas as $cama)
                            <option value="{{ $cama->id }}">Cama N° {{ $cama->number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editTipo" class="form-label">Tipo de Actividad</label>
                        <select class="form-select" id="editTipo" name="tipo" required>
                            <option value="mantenimiento">Mantenimiento</option>
                            <option value="alimentacion">Alimentación</option>
                            <option value="humedad">Humedad</option>
                            <option value="recoleccion">Recolección</option>
                            <option value="ph">Ph</option>
                            <option value="temperatura">Temperatura</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="editFecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="editFecha" name="fecha_actividad" required>
                    </div>

                    <div class="mb-3">
                        <label for="editHora" class="form-label">Hora</label>
                        <input type="time" class="form-control" id="editHora" name="hora_actividad">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const tipo = button.getAttribute('data-tipo');
            const cama = button.getAttribute('data-cama');
            const fecha = button.getAttribute('data-fecha');
            const hora = button.getAttribute('data-hora');

            const form = document.getElementById('editForm');
            form.action = `/lombrisoft/admin/bed_activities/${id}`;

            document.getElementById('editWormBed').value = cama;
            document.getElementById('editTipo').value = tipo;
            document.getElementById('editFecha').value = fecha;
            document.getElementById('editHora').value = hora;
        });
    });

    function confirmarEliminacion(element) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                element.closest('form').submit();
            }
        });
    }
</script>
@endsection