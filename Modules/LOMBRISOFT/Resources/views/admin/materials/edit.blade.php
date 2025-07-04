@extends('LOMBRISOFT::layouts.master')

@section('content')
    <h2>Editar Material</h2>

    <form action="{{ route('lombrisoft.admin.materials.update', $material->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nombre:</label>
        <input type="text" name="nombre" value="{{ $material->nombre }}" required><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="1" {{ $material->estado ? 'selected' : '' }}>Disponible</option>
            <option value="0" {{ !$material->estado ? 'selected' : '' }}>No Disponible</option>
        </select><br>

        <label>Cantidad:</label>
        <input type="number" name="cantidad" value="{{ $material->cantidad }}" min="0" required><br>

        <button type="submit">Actualizar</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
