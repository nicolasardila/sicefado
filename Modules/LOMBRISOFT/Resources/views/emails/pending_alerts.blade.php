<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>🚨 Alertas Vencidas - Sistema Lombrisoft</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #fff8f8 0%, #ffe6e6 100%);
            margin: 0; 
            padding: 20px; 
            color: #333;
        }
        .container { 
            max-width: 700px; 
            margin: auto; 
            background: #ffffff; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.15);
            border-left: 5px solid #dc3545;
        }
        .header {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .alert-count {
            background: #ffc107;
            color: #000;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 18px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 25px;
            font-size: 14px;
        }
        th, td { 
            padding: 12px 15px; 
            border: 1px solid #e0e0e0; 
            text-align: left; 
        }
        th { 
            background: linear-gradient(135deg, #495057 0%, #343a40 100%);
            color: white; 
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) { 
            background-color: #f8f9fa; 
        }
        tr:hover {
            background-color: #fff3cd;
            transition: background-color 0.2s ease;
        }
        .status-vencida {
            background-color: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
        }
        .status-proxima {
            background-color: #fd7e14;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
        }
        .status-activa {
            background-color: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
        }
        .urgent {
            background-color: #fff3cd;
            border-left: 4px solid #dc3545;
        }
        .footer { 
            margin-top: 30px; 
            font-size: 12px; 
            color: #6c757d; 
            text-align: center;
            padding: 15px;
            border-top: 1px solid #e9ecef;
        }
        .badge {
            background: #dc3545;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            margin-left: 5px;
        }
        .action-required {
            background: #f8d7da;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #dc3545;
        }
        .action-required h3 {
            margin: 0 0 10px 0;
            color: #721c24;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }
            table {
                font-size: 12px;
            }
            th, td {
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ <span>Alertas Vencidas</span> <span class="alert-count">{{ $alerts->count() }}</span></h1>
            <p>Sistema de Gestión de Lombricultivo - SENA</p>
        </div>

        <div class="action-required">
            <h3>🚨 Acción Requerida</h3>
            <p>Se han detectado <strong>{{ $alerts->count() }}</strong> alertas vencidas que requieren atención inmediata. Por favor, realice las actividades pendientes lo antes posible.</p>
        </div>

        <h2>📋 Detalles de Alertas Vencidas</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Cama</th>
                    <th>Actividad</th>
                    <th>Frecuencia</th>
                    <th>Última Ejecución</th>
                    <th>Próxima Esperada</th>
                    <th>Estado</th>
                    <th>Días de Retraso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alerts as $alert)
                @php
                    $diasRetraso = 0;
                    if ($alert->next_expected) {
                        $diasRetraso = now()->diffInDays($alert->next_expected);
                    }
                @endphp
                <tr class="{{ $diasRetraso > 7 ? 'urgent' : '' }}">
                    <td><strong>Cama #{{ $alert->wormBed->number ?? 'N/A' }}</strong></td>
                    <td>{{ ucfirst($alert->activity_type) }}</td>
                    <td>{{ $alert->frequency_days }} días</td>
                    <td>{{ $alert->last_execution ? $alert->last_execution->format('d/m/Y') : 'Nunca' }}</td>
                    <td>{{ $alert->next_expected ? $alert->next_expected->format('d/m/Y') : 'No definida' }}</td>
                    <td>
                        <span class="status-{{ $alert->calculated_status }}">
                            {{ strtoupper($alert->calculated_status) }}
                        </span>
                    </td>
                    <td>
                        @if($diasRetraso > 0)
                            <span style="color: #dc3545; font-weight: bold;">
                                {{ $diasRetraso }} días
                                @if($diasRetraso > 7)
                                    <span class="badge">CRÍTICO</span>
                                @endif
                            </span>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>📧 Este correo es generado automáticamente por el Sistema Lombrisoft</p>
            <p>🕐 Generado el: {{ now()->format('d/m/Y H:i:s') }}</p>
            <p>📍 SENA - Centro de Formación</p>
            <p><small>Si recibió este correo por error, por favor contacte al administrador del sistema.</small></p>
        </div>
    </div>
</body>
</html>