@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3 text-end">
                <a href="{{ route('lombrisoft.admin.materials.create') }}" class="btn btn-primary">Crear Nuevo Material</a>
            </div>
            <div class="card shadow-lg rounded">
                <div class="card-header bg-success text-white text-center">
                    <h4>Listado de Materiales</h4>
                </div>
                <div class="card-body">
                    @if ($materials->isEmpty())
                    <div class="alert alert-info text-center">
                        No hay materiales registrados.
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Estado</th>
                                    <th>Cantidad</th>
                                    <th>Fecha de Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materials as $material)
                                <tr>
                                    <td>{{ $material->id }}</td>
                                    <td>{{ $material->nombre }}</td>
                                    <td>{{ $material->estado_texto }}</td>
                                    <td>{{ $material->cantidad }}</td>
                                    <td>{{ $material->fecha_registro }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-id="{{ $material->id }}"
                                            data-nombre="{{ $material->nombre }}"
                                            data-estado="{{ $material->estado }}"
                                            data-cantidad="{{ $material->cantidad }}">
                                            Editar
                                        </button>
                                        <form action="{{ route('lombrisoft.admin.materials.destroy', $material->id) }}" method="POST" class="d-inline">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="editNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEstado" class="form-label">Estado</label>
                        <select class="form-select" id="editEstado" name="estado" required>
                            <option value="1">Disponible</option>
                            <option value="0">No Disponible</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editCantidad" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="editCantidad" name="cantidad" min="0" required>
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
            const nombre = button.getAttribute('data-nombre');
            const estado = button.getAttribute('data-estado');
            const cantidad = button.getAttribute('data-cantidad');

            const form = document.getElementById('editForm');
            form.action = `/lombrisoft/admin/materials/${id}`;
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editEstado').value = estado;
            document.getElementById('editCantidad').value = cantidad;
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
            confirmButtonText: '<span class="text-white">Sí, eliminar</span><br>',
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
