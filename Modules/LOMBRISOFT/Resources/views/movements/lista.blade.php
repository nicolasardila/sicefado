@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="mb-3 text-end">
                <a href="{{ route('lombrisoft.admin.movements.create') }}" class="btn btn-primary">Registrar Nuevo Movimiento</a>
            </div>

            {{-- ALERTA DE ÉXITO --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif
            {{-- ALERTA DE ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> {{ $errors->first() }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            <div class="card shadow-lg rounded">
                <div class="card-header bg-success text-white text-center">
                    <h4>Listado de Movimientos</h4>
                </div>
                <div class="card-body">
                    @if ($movimientos->isEmpty())
                        <div class="alert alert-info text-center">No hay movimientos registrados.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>ID</th>
                                        <th>Material</th>
                                        <th>Tipo</th>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($movimientos as $mov)
                                    <tr>
                                        <td>{{ $mov->id }}</td>
                                        <td>{{ $mov->material->nombre }}</td>
                                        <td>
                                            @if($mov->tipo == 'entrada')
                                                <span class="badge bg-success">Entrada</span>
                                            @else
                                                <span class="badge bg-danger">Salida</span>
                                            @endif
                                        </td>
                                        <td>{{ $mov->cantidad }}</td>
                                        <td>{{ $mov->descripcion ?? '-' }}</td>
                                        <td>{{ $mov->fecha_movimiento }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('lombrisoft.admin.movements.destroy', $mov->id) }}" method="POST" class="d-inline">
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

<script>
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
