<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TiendaController extends Controller
{
    public function registerTienda(Request $request)
    {
        // Validar los datos enviados
        $validate = Validator::make($request->all(), [
            'nombre'    => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'usuarioid' => 'required|integer', // Asegura que el usuario exista
            'longitud'  => 'nullable|numeric',
            'latitud'   => 'nullable|numeric',
            'telefono'  => 'nullable|string',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'code'   => 422,
                'errors' => $validate->errors(),
            ]);
        }

        try {
            // Crear la tienda
            $tienda = Tienda::create([
                'nombre'    => $request->nombre,
                'direccion' => $request->direccion,
                'usuarioid' => $request->usuarioid,
                'longitud'  => $request->longitud,
                'latitud'   => $request->latitud,
                'telefono'  => $request->telefono,
            ]);

            return response()->json([
                'status'  => 'success',
                'message' => 'Tienda registrada correctamente',
                'data'    => $tienda,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Hubo un error al registrar la tienda',
                'error'   => $e->getMessage(),
            ]);
        }
    }
}
