<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use App\Models\User;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    // Obtener todas las incidencias con la información del usuario
    public function index()
    {
        $problems = Problem::with('user')->get();
        return response()->json($problems);
    }

    // Crear una nueva incidencia
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'usuarioid' => 'required',
            'tipo' => 'required|string|max:100',
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
            'estado' => 'required',
        ]);

        $problem = Problem::create($validatedData);

        return response()->json($problem, 201);
    }

    // Actualizar el estado de una incidencia
    public function update(Request $request, $id)
    {
        $problem = Problem::findOrFail($id);

        $validatedData = $request->validate([
            'estado' => 'required',
        ]);

        $problem->update($validatedData);

        return response()->json($problem);
    }
}
