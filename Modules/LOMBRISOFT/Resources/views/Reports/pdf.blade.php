<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Actividades</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { background: #28a745; color: #fff; padding: 10px 0; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: center; }
        th { background: #eee; }
        .footer { text-align: right; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Actividades</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>Cama</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Fecha</th>
                <th>Hora</th>
                @if(!empty($columnas['cantidad_alimento'])) <th>Cantidad Alimento</th> @endif
                @if(!empty($columnas['tipo_alimento'])) <th>Tipo Alimento</th> @endif
                @if(!empty($columnas['nivel_humedad'])) <th>Nivel Humedad</th> @endif
                @if(!empty($columnas['tipo_recoleccion'])) <th>Tipo Recolección</th> @endif
                @if(!empty($columnas['cantidad_recolectada'])) <th>Cantidad Recolectada</th> @endif
                @if(!empty($columnas['ph'])) <th>PH</th> @endif
                @if(!empty($columnas['temperatura'])) <th>Temperatura</th> @endif
            </tr>
        </thead>
        <tbody>
            @forelse($actividades as $actividad)
                <tr>
                    <td>Cama N° {{ $actividad->wormBed->number ?? '-' }}</td>
                    <td><strong>{{ ucfirst($actividad->tipo) }}</strong></td>
                    <td><strong>{{ $actividad->descripcion }}</strong></td>
                    <td><strong>{{ $actividad->fecha_actividad }}</strong></td>
                    <td><strong>{{ $actividad->hora_actividad }}</strong></td>
                    @if(!empty($columnas['cantidad_alimento'])) <td>{{ $actividad->cantidad_alimento ?? '-' }}</td> @endif
                    @if(!empty($columnas['tipo_alimento'])) <td>{{ $actividad->tipo_alimento ?? '-' }}</td> @endif
                    @if(!empty($columnas['nivel_humedad'])) <td>{{ $actividad->nivel_humedad ?? '-' }}</td> @endif
                    @if(!empty($columnas['tipo_recoleccion'])) <td>{{ $actividad->tipo_recoleccion ?? '-' }}</td> @endif
                    @if(!empty($columnas['cantidad_recolectada'])) <td>{{ $actividad->cantidad_recolectada ?? '-' }}</td> @endif
                    @if(!empty($columnas['ph'])) <td>{{ $actividad->ph ?? '-' }}</td> @endif
                    @if(!empty($columnas['temperatura'])) <td>{{ $actividad->temperatura ?? '-' }}</td> @endif
                </tr>
            @empty
                <tr>
                    <td colspan="12">No hay actividades registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
