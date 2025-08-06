<?php

namespace Modules\LOMBRISOFT\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\LOMBRISOFT\Entities\WormBed;
use Modules\LOMBRISOFT\Entities\FeedingActivity;
use Modules\LOMBRISOFT\Entities\MoistureActivity;
use Modules\LOMBRISOFT\Entities\HarvestActivity;
use Modules\LOMBRISOFT\Entities\MaintenanceActivity;

class ActivityController extends Controller
{
    // Mostrar formulario de selección de tipo de actividad
    public function create()
    {
        return view('lombrisoft::Activitys.createactivity');
    }

    // Cargar formulario parcial según el tipo
    public function getFormByType($tipo)
    {
        $beds = WormBed::where('status', 'Disponible')->get();

        switch ($tipo) {
            case 'alimentacion':
                return view('lombrisoft::Activitys.alimentacion.form', compact('beds'));
            case 'humedad':
                return view('lombrisoft::Activitys.humedad.form', compact('beds'));
            case 'mantenimiento':
                return view('lombrisoft::Activitys.mantenimiento.form', compact('beds'));
            case 'recoleccion':
                return view('lombrisoft::Activitys.recoleccion.form', compact('beds'));
            default:
                abort(404, 'Tipo de actividad no válido');
        }
    }

    // Mostrar lista general de actividades
    public function listar()
    {
        $actividades = [];

        foreach (FeedingActivity::with('cama')->get() as $item) {
            $actividades[] = [
                'tipo' => 'alimentación',
                'cama' => optional($item->cama)->number,
                'detalle' => "Alimento: {$item->tipo_alimento}, Cant: {$item->cantidad} kg",
                'fecha' => $item->created_at->format('Y-m-d H:i'),
            ];
        }

        foreach (MoistureActivity::with('cama')->get() as $item) {
            $actividades[] = [
                'tipo' => 'humedad',
                'cama' => optional($item->cama)->number,
                'detalle' => "Observación: {$item->observaciones}",
                'fecha' => $item->created_at->format('Y-m-d H:i'),
            ];
        }

        foreach (HarvestActivity::with('cama')->get() as $item) {
            $actividades[] = [
                'tipo' => 'recolección',
                'cama' => optional($item->cama)->number,
                'detalle' => "{$item->producto} - Cantidad: {$item->cantidad}",
                'fecha' => $item->created_at->format('Y-m-d H:i'),
            ];
        }

        foreach (MaintenanceActivity::with('cama')->get() as $item) {
            $actividades[] = [
                'tipo' => 'mantenimiento',
                'cama' => optional($item->cama)->number,
                'detalle' => "{$item->tipo}: {$item->descripcion}",
                'fecha' => $item->created_at->format('Y-m-d H:i'),
            ];
        }

        // Ordenar por fecha descendente
        usort($actividades, fn($a, $b) => strtotime($b['fecha']) <=> strtotime($a['fecha']));

        return view('lombrisoft::Activitys.listaactivity', compact('actividades'));
    }

    // Este método ya no es necesario y fue eliminado:
    // public function lista() { ... }
}
