<?php

namespace Modules\LOMBRISOFT\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\LOMBRISOFT\Entities\Material;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::all();
        return view('lombrisoft::materials.listamaterials', compact('materials'));
    }

    public function create()
    {
        return view('lombrisoft::materials.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:materials,nombre',
            'estado' => 'required|boolean',
            'cantidad' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lombrisoft.admin.materials.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        Material::create([
            'nombre' => $request->nombre,
            'estado' => $request->estado,
            'cantidad' => $request->cantidad,
            'fecha_registro' => now(),
        ]);

        return redirect()->route('lombrisoft.admin.materials.index')
                         ->with('success', 'Material creado correctamente.');
    }

    public function show($id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json(['mensaje' => 'Material no encontrado'], 404);
        }

        return response()->json($material, 200);
    }

    public function edit($id)
    {
        $material = Material::find($id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material no encontrado');
        }
        return view('lombrisoft::materials.edit', compact('material'));
    }

    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:materials,nombre,' . $material->id,
            'estado' => 'required|in:0,1',
            'cantidad' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lombrisoft.admin.materials.index')
                             ->withErrors($validator)
                             ->withInput()
                             ->with('edit_error_id', $material->id);
        }

        $material->update([
            'nombre' => $request->nombre,
            'estado' => $request->estado,
            'cantidad' => $request->cantidad,
        ]);

        return redirect()->route('lombrisoft.admin.materials.index')
                         ->with('success', 'Material actualizado correctamente.');
    }

    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        $material->delete();

        return redirect()->route('lombrisoft.admin.materials.index')
                         ->with('success', 'Material eliminado correctamente.');
    }
}
