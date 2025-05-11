<?php

namespace App\Http\Controllers;

use App\Models\NotificacionRepartidor;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotificacionRepartidorController extends Controller
{
    public function obtenerMensajes()
    {

        $mensajes = NotificacionRepartidor::with('remitente') // Carga la relación con el remitente
        ->orderBy('fecha', 'asc')
        ->orderBy('hora', 'asc')
        ->get();

        $mensajes = $mensajes->map(function ($mensaje) {
            return [
                'mensaje' => $mensaje->mensaje,
                'fecha' => $mensaje->fecha,
                'hora' => $mensaje->hora,
                'remitente' => $mensaje->remitente->usuarionombre ?? 'Desconocido', // Asegúrate de que el modelo User tenga 'name'
            ];
        });

        return response()->json($mensajes);
    }

    public function enviarMensaje(Request $request)
    {
        $request->validate([
            'mensaje' => 'required|string|max:255',
            'remitente_id' => 'required|exists:users,usuarioid',
        ]);

        $nuevoMensaje = NotificacionRepartidor::create([
            'mensaje' => $request->mensaje,
            'fecha' => Carbon::now()->format('Y-m-d'),
            'hora' => Carbon::now()->format('H:i'),
            'remitente_id' => $request->remitente_id,
        ]);

        return response()->json($nuevoMensaje, 201);
    }
}
