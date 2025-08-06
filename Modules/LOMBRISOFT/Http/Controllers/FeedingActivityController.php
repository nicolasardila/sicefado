<?php

namespace Modules\LOMBRISOFT\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LOMBRISOFT\Entities\FeedingActivity;
use Modules\LOMBRISOFT\Entities\WormBed;

class FeedingActivityController extends Controller
{
    public function index()
    {
        $actividades = FeedingActivity::with('cama')->get();
        return view('lombrisoft::feeding.index', compact('actividades'));
    }

    public function create()
    {
        $camas = WormBed::where('status', 'Disponible')->get();
        return view('lombrisoft::feeding.create', compact('camas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'worm_bed_id' => 'required|exists:wormsBeds,id',
            'tipo_alimento' => 'required|string',
            'cantidad' => 'required|numeric|min:0',
            'observaciones' => 'nullable|string|max:500',
        ]);

        FeedingActivity::create([
            'worm_bed_id' => $request->worm_bed_id,
            'tipo_alimento' => $request->tipo_alimento,
            'cantidad' => $request->cantidad,
            'observaciones' => $request->observaciones,
            'fecha' => now(),
        ]);

        return redirect()->route('lombrisoft.feeding.index')
                         ->with('success', 'Actividad de alimentación registrada correctamente.');
    }
}
