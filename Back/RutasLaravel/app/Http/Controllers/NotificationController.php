<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Notification;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;
class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();

        return response()->json($notifications);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'fecha' => 'required|date',
            'remitente_id' => 'required|integer',
            'destinatario_id' => 'required|integer',
            'tipo_notificacion' => 'nullable|string',
            'productos_seleccionados' => 'nullable|string',
            'precio' => 'required|numeric',
            'tipo_oferta_aviso' => 'required|string',
            'descripcion' => 'required|string',
            'imagen' => 'nullable',
            'puntos' => 'nullable|string',
        ]);

        $notification = new Notification($validated);
        
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('images', 'public');
            $notification->imagen = $path;
        }

        $notification->save();

        return response()->json($notification, 201);
    }

}
