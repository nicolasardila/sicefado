<?php

namespace Modules\LOMBRISOFT\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\LOMBRISOFT\Entities\Material;

class MaterialController extends Controller
{
    // Listar todos los materiales
    public function index()
    {
        $materials = Material::all();
        return response()->json($materials, 200);
    }

    // Mostrar formulario para crear (si usas Blade)
    public function create()
    {
        return view('lombrisoft::materials.create');
    }

    // Guardar un nuevo material
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'estado' => 'required|boolean',
            'cantidad' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }

        $material = Material::create([
            'nombre' => $request->nombre,
            'estado' => $request->estado,
            'cantidad' => $request->cantidad,
            'fecha_registro' => now(),
        ]);

        return response()->json($material, 201);
    }

    // Mostrar un material específico
    public function show($id)
    {
        $material = Material::find($id);

        if (!$material) {
            return response()->json(['mensaje' => 'Material no encontrado'], 404);
        }

        return response()->json($material, 200);
    }

    // Mostrar formulario de edición (si usas Blade)
    public function edit($id)
    {
        $material = Material::find($id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material no encontrado');
        }
        return view('lombrisoft::materials.edit', compact('material'));
    }

    // Actualizar un material
    public function update(Request $request, $id)
    {
        $material = Material::find($id);
        if (!$material) {
            return response()->json(['mensaje' => 'Material no encontrado'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|required|string|max:100',
            'estado' => 'sometimes|required|boolean',
            'cantidad' => 'sometimes|required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errores' => $validator->errors()], 422);
        }

        $material->update($request->only(['nombre', 'estado', 'cantidad']));
        return response()->json($material, 200);
    }

    // Eliminar un material
    public function destroy($id)
    {
        $material = Material::find($id);
        if (!$material) {
            return response()->json(['mensaje' => 'Material no encontrado'], 404);
        }

        $material->delete();
        return response()->json(['mensaje' => 'Material eliminado correctamente'], 200);
    }
}
