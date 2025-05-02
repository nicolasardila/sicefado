@extends('LOMBRISOFT::layouts.master')

@section('content')
    <h2>Editar Cama de Lombrices</h2>

    <form action="{{ route('wormsBeds.update', $bed->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Número:</label>
        <input type="number" name="number" value="{{ $bed->number }}" required><br>

        <label>Estado:</label>
        <input type="text" name="status" value="{{ $bed->status }}" required><br>

        <label>Fecha de inicio:</label>
        <input type="date" name="start_date" value="{{ $bed->start_date }}" required><br>

        <button type="submit">Actualizar</button>
    </form>
@endsection
