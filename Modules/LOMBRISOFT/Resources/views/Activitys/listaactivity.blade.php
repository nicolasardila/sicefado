@extends('lombrisoft::layouts.master')

@section('content')
<div class="container mt-5">
    <h3 class="mb-4 text-center">Listado de Actividades</h3>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            @if ($actividades->isEmpty())
                <div class="alert alert-info text-center">No hay actividades registradas.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Tipo</th>
                                <th>Cama</th>
                                <th>Detalles</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actividades as $actividad)
                                <tr>
                                    <td>{{ ucfirst($actividad['tipo']) }}</td>
                                    <td>Cama #{{ $actividad['cama'] ?? '-' }}</td>
                                    <td>{{ $actividad['detalle'] }}</td>
                                    <td>{{ $actividad['fecha'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
