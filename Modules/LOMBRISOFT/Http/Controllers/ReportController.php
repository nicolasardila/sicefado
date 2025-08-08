<?php

namespace Modules\LOMBRISOFT\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LOMBRISOFT\Entities\Report;
use Modules\LOMBRISOFT\Entities\WormBed;
use Modules\LOMBRISOFT\Entities\BedActivity;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
public function index(Request $request)
{
    $beds = WormBed::all();

    $query = BedActivity::with('wormBed');

    if ($request->filled('tipo')) {
        $tipos = $request->input('tipo');
        if (is_array($tipos)) {
            $query->whereIn('tipo', $tipos);
        } else {
            $query->where('tipo', $tipos);
        }
    }
    if ($request->filled('worm_bed_id')) {
        $query->where('worm_bed_id', $request->worm_bed_id);
    }
    if ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha_actividad', '>=', $request->fecha_inicio);
    }
    if ($request->filled('fecha_fin')) {
        $query->whereDate('fecha_actividad', '<=', $request->fecha_fin);
    }

    $actividades = $query->orderBy('fecha_actividad', 'desc')->get();

    return view('lombrisoft::Reports.index', compact('actividades', 'beds'));
}

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $beds = WormBed::all();
        $activities = BedActivity::all();
        return view('LOMBRISOFT::Reports.create', compact('beds', 'activities'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'worm_bed_id' => 'required|exists:wormsBeds,id',
            'activity_id' => 'required|exists:bed_activities,id',
            'observaciones' => 'nullable|string',
        ]);

        \Modules\LOMBRISOFT\Entities\Report::create([
            'worm_bed_id' => $request->worm_bed_id,
            'activity_id' => $request->activity_id,
            'observaciones' => $request->observaciones,
            'fecha' => now()
        ]);

        return redirect()->route('reports.index')->with('success', 'Reporte creado correctamente');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('lombrisoft::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('lombrisoft::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

   public function exportPdf(Request $request)
{
    $query = BedActivity::with([
        'wormBed',
        'feeding',
        'moisture',
        'harvest',
        'ph',
        'temperature'
    ]);

    if ($request->filled('tipo')) {
        $tipos = $request->input('tipo');
        if (is_array($tipos)) {
            $query->whereIn('tipo', $tipos);
        } else {
            $query->where('tipo', $tipos);
        }
    }

    if ($request->filled('worm_bed_id')) {
        $query->where('worm_bed_id', $request->worm_bed_id);
    }

    if ($request->filled('fecha_inicio')) {
        $query->whereDate('fecha_actividad', '>=', $request->fecha_inicio);
    }

    if ($request->filled('fecha_fin')) {
        $query->whereDate('fecha_actividad', '<=', $request->fecha_fin);
    }

    $actividades = $query->orderBy('fecha_actividad', 'desc')->get();

    // Detectar columnas con datos
    $columnas = [
        'feeding' => false,
        'moisture' => false,
        'harvest' => false,
        'ph' => false,
        'temperature' => false,
    ];

    foreach ($actividades as $actividad) {
        if ($actividad->feeding) $columnas['feeding'] = true;
        if ($actividad->moisture) $columnas['moisture'] = true;
        if ($actividad->harvest) $columnas['harvest'] = true;
        if ($actividad->ph) $columnas['ph'] = true;
        if ($actividad->temperature) $columnas['temperature'] = true;
    }

    $pdf = Pdf::loadView('lombrisoft::Reports.pdf', compact('actividades', 'columnas'));
    return $pdf->download('actividades.pdf');
}


  
}
