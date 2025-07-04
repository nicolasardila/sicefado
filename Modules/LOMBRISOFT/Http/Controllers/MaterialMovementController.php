<?php

namespace Modules\LOMBRISOFT\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\LOMBRISOFT\Entities\Material;
use Modules\LOMBRISOFT\Entities\MaterialMovement;

class MaterialMovementController extends Controller
{
    public function index()
    {
        $movimientos = MaterialMovement::with('material')->latest()->get();
        return view('lombrisoft::movements.lista', compact('movimientos'));
    }

    public function create()
    {
        $materials = Material::all();
        return view('lombrisoft::movements.create', compact('materials'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materials,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'descripcion' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lombrisoft.admin.movements.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        $material = Material::findOrFail($request->material_id);
        $cantidad = $request->cantidad;

        // Actualizar la cantidad en materials
        if ($request->tipo == 'entrada') {
            $material->cantidad += $cantidad;
        } elseif ($request->tipo == 'salida') {
            if ($material->cantidad < $cantidad) {
                return redirect()->route('lombrisoft.admin.movements.create')
                                 ->withErrors(['cantidad' => 'La cantidad solicitada excede el stock disponible.'])
                                 ->withInput();
            }
            $material->cantidad -= $cantidad;
        }

        $material->save();

        MaterialMovement::create([
            'material_id' => $request->material_id,
            'tipo' => $request->tipo,
            'cantidad' => $cantidad,
            'descripcion' => $request->descripcion,
            'fecha_movimiento' => now(),
        ]);

        return redirect()->route('lombrisoft.admin.movements.index')
                         ->with('success', 'Movimiento registrado correctamente.');
    }

    public function show($id)
    {
        $movimiento = MaterialMovement::with('material')->find($id);

        if (!$movimiento) {
            return response()->json(['mensaje' => 'Movimiento no encontrado'], 404);
        }

        return response()->json($movimiento, 200);
    }

    public function destroy($id)
    {
        $movimiento = MaterialMovement::findOrFail($id);

        // Si se desea revertir stock al eliminar un movimiento
        $material = $movimiento->material;
        if ($movimiento->tipo == 'entrada') {
            $material->cantidad -= $movimiento->cantidad;
        } elseif ($movimiento->tipo == 'salida') {
            $material->cantidad += $movimiento->cantidad;
        }
        $material->save();

        $movimiento->delete();

        return redirect()->route('lombrisoft.admin.movements.index')
                         ->with('success', 'Movimiento eliminado correctamente y stock actualizado.');
    }
}
