<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function agregarProducto(Request $request)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'productoid' => 'required|exists:products,id',
            'cantidad' => 'required|integer|min:1',
            'clienteid' => 'required|exists:users,usuarioid', // Verificar que el clienteid exista en la tabla de usuarios
        ]);

        // Obtener el producto y calcular el subtotal
        $producto = Product::find($validatedData['productoid']);
        $precioUnitario = $producto->precio;
        $subtotal = $precioUnitario * $validatedData['cantidad'];

        // Buscar o crear el pedido activo del usuario
        $pedido = Pedido::firstOrCreate(
            [
                'clienteid' => $validatedData['clienteid'],
                'pedido_por_confirmar' => true
            ],
            [
                'pedido_fecha' => Carbon::now(),
                'pedido_total' => 0,
                'pedido_por_confirmar' => true,
            ]
        );

        // Buscar si ya existe una entrada para el mismo producto en el pedido
        $pedidoProducto = PedidoProducto::where('pedidoid', $pedido->pedidoid)
                                        ->where('productoid', $producto->id)
                                        ->first();

        if ($pedidoProducto) {
            // Si ya existe, actualiza la cantidad sumándola a la cantidad actual
            $pedidoProducto->cantidad += $validatedData['cantidad'];
            $pedidoProducto->save();
        } else {
            // Si no existe, crea una nueva entrada
            PedidoProducto::create([
                'pedidoid' => $pedido->pedidoid,
                'productoid' => $producto->id,
                'cantidad' => $validatedData['cantidad'],
            ]);
        }

        // Actualizar el total del pedido
        $pedido->pedido_total += $subtotal;
        $pedido->save();

        return response()->json(['message' => 'Producto agregado al carrito', 'pedido' => $pedido], 200);
    }

    // public function verCarrito($clienteid)
    // {
    //     // Buscar el pedido activo del usuario
    //     $pedido = Pedido::where('clienteid', $clienteid)
    //                     ->where('pedido_por_confirmar', true)
    //                     ->with('productos.producto') // Cargar los productos y sus detalles
    //                     ->first();

    //     if (!$pedido) {
    //         return response()->json(['message' => 'No hay un carrito activo para este usuario.'], 404);
    //     }

    //     // Calcular el total de productos y devolver el pedido con sus productos
    //     return response()->json([
    //         'pedido' => $pedido,
    //         'productos' => $pedido->productos->map(function ($pedidoProducto) {
    //             return [
    //                 'id' => $pedidoProducto->producto->id,
    //                 'name' => $pedidoProducto->producto->name, // Asegúrate de que el nombre del producto esté definido
    //                 'package' => $pedidoProducto->producto->package, // Si tienes algún campo de paquete
    //                 'detail' => $pedidoProducto->producto->detail, // Campo de detalle
    //                 'sku' => $pedidoProducto->producto->sku,
    //                 'image' => $pedidoProducto->producto->image, // Ajusta el nombre según tu base de datos
    //                 'cantidad' => $pedidoProducto->cantidad,
    //                 'subtotal' => $pedidoProducto->producto->cost * $pedidoProducto->cantidad,
    //             ];
    //         }),
    //         'total' => $pedido->pedido_total,
    //     ], 200);
    // }
    public function verCarrito($clienteid)
    {
        $pedido = Pedido::where('clienteid', $clienteid)
                        ->where('pedido_por_confirmar', true)
                        ->with('productos.producto')
                        ->first();

        if (!$pedido) {
            return response()->json(['message' => 'No hay un carrito activo para este usuario.'], 404);
        }

        $productos = $pedido->productos->map(function ($pedidoProducto) {
            return [
                'id' => $pedidoProducto->producto->id,
                'name' => $pedidoProducto->producto->name,
                'package' => $pedidoProducto->producto->package,
                'detail' => $pedidoProducto->producto->detail,
                'sku' => $pedidoProducto->producto->sku,
                'cost' => $pedidoProducto->producto->cost,
                'image' => $pedidoProducto->producto->image,
                'cantidad' => $pedidoProducto->cantidad,
                'subtotal' => $pedidoProducto->producto->cost * $pedidoProducto->cantidad,
            ];
        });

        $total = $productos->sum('subtotal'); // Sumar subtotales

        return response()->json([
            'pedido' => $pedido,
            'productos' => $productos,
            'total' => $total,
        ], 200);
    }

    public function enviarPedido($clienteid)
    {
        // Buscar el pedido activo del cliente
        $pedido = Pedido::where('clienteid', $clienteid)
                        ->where('pedido_por_confirmar', 1)
                        ->first();

        if (!$pedido) {
            return response()->json(['message' => 'No hay un pedido activo para confirmar.'], 404);
        }

        // Cambiar el estado del pedido
        $pedido->pedido_por_confirmar = 2;
        $pedido->save();

        return response()->json(['message' => 'Pedido confirmado correctamente.'], 200);
    }

    public function confirmarPedido($clienteid)
    {
        // Buscar el pedido activo del cliente
        $pedido = Pedido::where('clienteid', $clienteid)
                        ->where('pedido_por_confirmar', 2)
                        ->first();

        if (!$pedido) {
            return response()->json(['message' => 'No hay un pedido activo para confirmar.'], 404);
        }

        // Cambiar el estado del pedido
        $pedido->pedido_por_confirmar = 0;
        $pedido->save();

        return response()->json(['message' => 'Pedido confirmado correctamente.'], 200);
    }

    public function obtenerConteoPedidos()
    {
        // $pedidosTotales = Pedido::count();
        $pedidosConfirmados = Pedido::where('pedido_por_confirmar', 0)->count();
        $pedidosPendientes = Pedido::where('pedido_por_confirmar', 2)->count();
        $pedidosTotales = $pedidosConfirmados + $pedidosPendientes;

        return response()->json([
            'pedidosTotales' => $pedidosTotales,
            'pedidosConfirmados' => $pedidosConfirmados,
            'pedidosPendientes' => $pedidosPendientes,
        ], 200);
    }

    public function getPedidosConTiendaInfo()
    {
        try {
            $pedidos = Pedido::with(['tienda', 'usuario'])
                ->where('pedido_por_confirmar', 2)
                ->get()
                ->map(function ($pedido) {
                    return [
                        'id' => $pedido->pedidoid,
                        'shopname' => $pedido->tienda->nombre,
                        'location' => $pedido->tienda->direccion,
                        'owner' => $pedido->usuario->usuarionombre,
                        'paystatus' => $pedido->pedido_por_confirmar == 1 ? 'Pago pendiente' : 'Pagado',
                        'image' => 'https://via.placeholder.com/100',
                        'userId' => $pedido->usuario->usuarioid
                    ];
                });

            return response()->json([
                'status' => 'success',
                'data' => $pedidos,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los pedidos: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getProductosDePedido($pedidoId)
    {
        try {
            $pedido = Pedido::with('productos.producto')->findOrFail($pedidoId);

            $productos = $pedido->productos->map(function ($pedidoProducto) {
                return [
                    'id' => $pedidoProducto->producto->id,
                    'name' => $pedidoProducto->producto->name,
                    'package' => $pedidoProducto->producto->package,
                    'detail' => $pedidoProducto->producto->detail,
                    'sku' => $pedidoProducto->producto->sku,
                    'cost' => $pedidoProducto->producto->cost,
                    'image' => $pedidoProducto->producto->image,
                    'cantidad' => $pedidoProducto->cantidad,
                    'subtotal' => $pedidoProducto->producto->cost * $pedidoProducto->cantidad,
                ];
            });

            $total = $productos->sum('subtotal');

            return response()->json([
                'productos' => $productos,
                'total' => $total,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener los productos del pedido: ' . $e->getMessage(),
            ], 500);
        }
    }

}
