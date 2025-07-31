<?php

namespace Modules\LOMBRISOFT\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LOMBRISOFT\Entities\BedActivity;
use Modules\LOMBRISOFT\Entities\WormBed;
use DB;
use Illuminate\Support\Facades\Validator;


class BedActivityController extends Controller
{
    // Mostrar lista de actividades
    public function index()
    {
        $activities = BedActivity::with(['wormBed'])->get();
        $camas = WormBed::all();;

        return view('lombrisoft::bed_activities.index', compact('activities', 'camas'));
    }

    // Formulario de creación
    public function create()
    {
        $camas = WormBed::all();
        return view('lombrisoft::bed_activities.create', compact('camas'));
    }

    // Guardar nueva actividad
    public function store(Request $request)
    {
        $request->validate([
            'worm_bed_id' => 'required|exists:wormsBeds,id',
            'tipo' => 'required|in:mantenimiento,alimentacion,humedad,recoleccion,ph,temperatura',
            'fecha_actividad' => 'required|date',
        ]);

        if ($request->tipo === 'alimentacion') {
            $request->validate([
                'cantidad_alimento' => 'required|integer|min:1',
                'tipo_alimento' => 'required|string|max:255',
            ]);
        }

        if ($request->tipo === 'humedad') {
            $request->validate([
                'nivel_humedad' => 'required|numeric|min:0|max:100',
            ]);
        }

        if ($request->tipo === 'recoleccion') {
            $request->validate([
                'tipo_recoleccion' => 'required|in:humus,lixiviado',
                'cantidad_recolectada' => 'required|integer|min:1',
            ]);
        }
        if ($request->tipo === 'ph') {
            $request->validate([
                'ph' => 'required|numeric|min:0|max:14',
            ]);
        }
        if ($request->tipo === 'temperatura') {
            $request->validate([
                'temperatura' => 'required|numeric|min:-50|max:50',
            ]);
        }

        // Transacción para evitar inconsistencias
        DB::beginTransaction();

        try {
            $actividad = new BedActivity($request->all());
            $actividad->tipo_alimento = $request->tipo_alimento ?? null;
            $actividad->save();
            

            DB::commit();
            return redirect()->route('lombrisoft.admin.bed_activities.index')->with('success', 'Actividad registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Actualizar actividad (opcional: agregar lógica para update de herramientas si quieres)
    public function update(Request $request, $id)
    {
        $actividad = BedActivity::findOrFail($id);

        $request->validate([
            'worm_bed_id' => 'required|exists:wormsBeds,id',
            'tipo' => 'required|in:mantenimiento,alimentacion,humedad,recoleccion',
            'fecha_actividad' => 'required|date',
        ]);

        $actividad->update($request->all());

        return redirect()->route('lombrisoft.admin.bed_activities.index')->with('success', 'Actividad actualizada correctamente.');
    }

    // Eliminar actividad
    public function destroy($id)
    {
        $actividad = BedActivity::findOrFail($id);
        $actividad->delete();

        return redirect()->route('lombrisoft.admin.bed_activities.index')->with('success', 'Actividad eliminada correctamente.');
    }
}
