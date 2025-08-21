@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">

    {{-- ✅ Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- ❌ Mensajes de error de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>¡Error!</strong> Por favor revisa los campos del formulario.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3 text-end">
                <a href="{{ route('lombrisoft.admin.camas.create') }}" class="btn btn-primary">Crear Nueva Cama</a>
            </div>
            <div class="card shadow-lg rounded">
                <div class="card-header bg-success text-white text-center">
                    <h4>Listado de Camas</h4>
                </div>
                <div class="card-body">
                    @if ($camas->isEmpty())
                        <div class="alert alert-info text-center">
                            No hay camas registradas.
                        </div>
                    @else
                        <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Número de Cama</th>
                <th>Estado</th>
                <th>Fecha de Inicio</th>
                <th style="width: 140px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($camas as $cama)
            <tr>
                <td>{{ $cama->number }}</td>
                <td>{{ $cama->status }}</td>
                <td>{{ $cama->start_date }}</td>
                <td class="text-center">
                    <button type="button"
                            class="btn btn-sm btn-outline-success me-1"
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal"
                            data-id="{{ $cama->id }}"
                            data-number="{{ $cama->number }}"
                            data-status="{{ $cama->status }}"
                            data-start_date="{{ $cama->start_date }}"
                            title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>

                    <form action="{{ route('lombrisoft.admin.camas.destroy', $cama->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                class="btn btn-sm btn-outline-danger" 
                                onclick="confirmarEliminacion(this)"
                                title="Eliminar">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Modal de Edición -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="editForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Cama</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="editNumero" class="form-label">Número de la Cama</label>
            <input type="number" class="form-control @error('numero') is-invalid @enderror" id="editNumero" name="numero" required>
            @error('numero')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="editEstado" class="form-label">Estado</label>
            <select class="form-select" id="editEstado" name="estado" required>
              <option value="Disponible">Disponible</option>
              <option value="Ocupada">Ocupada</option>
              <option value="Mantenimiento">Mantenimiento</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editFechaInicio" class="form-label">Fecha de Inicio</label>
            <input type="date" class="form-control" id="editFechaInicio" name="fecha_inicio" required>
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
document.addEventListener('DOMContentLoaded', function () {
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const number = button.getAttribute('data-number');
        const status = button.getAttribute('data-status');
        const startDate = button.getAttribute('data-start_date');

        const form = document.getElementById('editForm');
        form.action = `/lombrisoft/admin/camas/${id}`;
        document.getElementById('editNumero').value = number;
        document.getElementById('editEstado').value = status;
        document.getElementById('editFechaInicio').value = startDate;
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
        confirmButtonText: '<span class="text-white">Sí, eliminar</span>',
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
