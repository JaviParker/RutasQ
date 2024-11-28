<?php

namespace App\Http\Controllers;

use App\Models\HistorialCompra;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistorialCompraController extends Controller
{
    public function registrarCompra(Request $request)
    {
        $data = $request->validate([
            'productos' => 'required|array',
            'total' => 'required|string',
        ]);

        $fechaActual = Carbon::now();
        $historial = HistorialCompra::create([
            'diaNombre' => $fechaActual->format('l'),
            'diaNumero' => $fechaActual->format('d'),
            'mes' => $fechaActual->format('F'),
            'año' => $fechaActual->format('Y'),
            'total' => $data['total'],
        ]);

        foreach ($data['productos'] as $producto) {
            Product::where('id', $producto['id'])->decrement('quantity', $producto['cantidad']);
        }

        return response()->json(['message' => 'Compra registrada con éxito', 'historial' => $historial]);
    }

    public function obtenerIngresosDelDia()
    {
        $fechaActual = Carbon::now();
        $diaNombre = $fechaActual->format('l'); // Ejemplo: "Thursday"
        $diaNumero = $fechaActual->format('d'); // Ejemplo: "28"

        $ingresos = HistorialCompra::where('diaNombre', $diaNombre)
            ->where('diaNumero', $diaNumero)
            ->sum('total'); // Asegúrate de que 'total' sea el campo correcto en la base de datos

        return response()->json(['totalIngresos' => $ingresos], 200);
    }

    public function obtenerIngresosPorDia()
    {
        $ingresos = HistorialCompra::select('diaNombre', 'diaNumero', \DB::raw('SUM(total) as totalIngresos'))
            ->groupBy('diaNombre', 'diaNumero')
            ->orderBy('diaNumero')
            ->get();

        return response()->json($ingresos, 200);
    }

}
