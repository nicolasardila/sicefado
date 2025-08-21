<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alerta de Actividad Vencida</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6fa;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        h1 {
            font-size: 24px;
            color: #2f3640;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            margin: 5px 0;
        }
        .alert-summary {
            font-weight: bold;
            margin-bottom: 15px;
            color: #e84118;
        }
        .details {
            border: 1px solid #dcdde1;
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f1f2f6;
        }
        .details h2 {
            margin-top: 0;
            font-size: 18px;
            color: #40739e;
            border-bottom: 1px solid #dcdde1;
            padding-bottom: 5px;
        }
        .details p {
            margin: 4px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #718093;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Alerta de Actividad Vencida</h1>

        <p class="alert-summary">
            La cama automática <strong>#{{ $wormBed->number }}</strong> tiene <strong>{{ $activities->count() }}</strong> actividades vencidas.
        </p>

        @forelse($activities as $activity)
            <div class="details">
                <h2>{{ ucfirst($activity->tipo ?? 'Actividad') }}</h2>
                <p><strong>Fecha programada:</strong> {{ \Carbon\Carbon::parse($activity->fecha_actividad)->format('d/m/Y') }}</p>

                @if(!empty($activity->descripcion))
                    <p><strong>Descripción:</strong> {{ $activity->descripcion }}</p>
                @endif

                @if($activity->tipo === 'alimentacion')
                    <p><strong>Cantidad de alimento:</strong> {{ $activity->feeding->cantidad_alimento ?? '-' }}</p>
                    <p><strong>Tipo de alimento:</strong> {{ $activity->feeding->tipo_alimento ?? '-' }}</p>
                @elseif($activity->tipo === 'humedad')
                    <p><strong>Nivel de humedad:</strong> {{ $activity->moisture->nivel_humedad ?? '-' }}%</p>
                @elseif($activity->tipo === 'recoleccion')
                    <p><strong>Tipo de recolección:</strong> {{ $activity->harvest->tipo_recoleccion ?? '-' }}</p>
                    <p><strong>Cantidad recolectada:</strong> {{ $activity->harvest->cantidad_recolectada ?? '-' }}</p>
                @elseif($activity->tipo === 'ph')
                    <p><strong>pH:</strong> {{ $activity->ph->ph ?? '-' }}</p>
                @elseif($activity->tipo === 'temperatura')
                    <p><strong>Temperatura:</strong> {{ $activity->temperature->temperatura ?? '-' }}°C</p>
                @endif
            </div>
        @empty
            <p>No hay actividades vencidas.</p>
        @endforelse

        <div class="footer">
            Este correo es generado automáticamente por el sistema Lombrisoft.
        </div>
    </div>
</body>
</html>
