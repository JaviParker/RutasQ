<?php

namespace App\Http\Controllers;

use App\Models\HistorialCompra;
use App\Models\Product;
use App\Models\PedidoProducto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HistorialCompraController extends Controller
{

    private $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

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
            'mes' => $fechaActual->format('m'),
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

    public function obtenerEstadisticasSemanales()
    {
        $historial = HistorialCompra::orderBy('año', 'desc')
            ->orderBy('mes', 'desc')
            ->orderBy('diaNumero', 'desc')
            ->get();

        $semanas = [];
        $semanaActual = [];
        $inicioSemana = null;
        $totalIngresosSemana = 0;

        foreach ($historial as $registro) {
            // Crear una fecha ficticia para facilitar cálculos
            $fechaRegistro = \Carbon\Carbon::create($registro->año, $registro->mes, $registro->diaNumero);

            // Si es el primer registro, inicializar la semana
            if (is_null($inicioSemana)) {
                $inicioSemana = $fechaRegistro;
            }

            // Si la diferencia con el inicio de la semana supera los 7 días, guardar la semana actual y comenzar una nueva
            if ($fechaRegistro->diffInDays($inicioSemana) >= 7) {
                $semanas[] = [
                    'numeroSemana' => count($semanas) + 1,
                    'totalIngresos' => $totalIngresosSemana,
                ];
                $inicioSemana = $fechaRegistro;
                $totalIngresosSemana = 0;
                $semanaActual = [];
            }

            // Sumar ingresos y agregar al registro de la semana actual
            $totalIngresosSemana += $registro->total;
            $semanaActual[] = $registro;
        }

        // Agregar la última semana procesada si no está vacía
        if (!empty($semanaActual)) {
            $semanas[] = [
                'numeroSemana' => count($semanas) + 1,
                'totalIngresos' => $totalIngresosSemana,
            ];
        }

        // Obtener los productos más vendidos (misma lógica)
        $topProductos = PedidoProducto::selectRaw('
                productoid,
                SUM(cantidad) as totalVendido
            ')
            ->join('pedido', 'pedido_productos.pedidoid', '=', 'pedido.pedidoid')
            ->where('pedido.pedido_por_confirmar', false) // Solo pedidos confirmados
            ->groupBy('productoid')
            ->orderBy('totalVendido', 'desc')
            ->take(3)
            ->get();

        $productos = Product::whereIn('id', $topProductos->pluck('productoid'))->get();
        $topProductos = $topProductos->map(function ($producto) use ($productos) {
            $producto->nombre = $productos->where('id', $producto->productoid)->first()->nombre ?? 'Producto desconocido';
            return $producto;
        });

        return response()->json([
            'semanas' => $semanas,
            'topProductos' => $topProductos,
        ], 200);
    }

    public function obtenerMes()
    {
        $mesesNumericos = HistorialCompra::select('mes')->distinct()->pluck('mes');
        $nombresMeses = $mesesNumericos->map(function ($numeroMes) {
            return $this->meses[$numeroMes];
        });
        return response()->json($nombresMeses);
    }
}
