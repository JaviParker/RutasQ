<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'package' => 'required|string|max:100',
            'detail' => 'required|string|max:100',
            'sku' => 'required|integer',
            'cost' => 'required|string|max:100',
            'quantity' => 'required|string|max:100',
            'image' => 'nullable',
            'category' => 'required'
        ]);

        // Crear el producto
        $product = Product::create($validatedData);

        // Responder con el producto creado
        return response()->json([
            'message' => 'Producto creado exitosamente.',
            'product' => $product,
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        // Depuración inicial
        \Log::info("ID recibido: $id");
        \Log::info("Datos recibidos: ", $request->all());
        \Log::info('Datos recibidos json encode: ' . json_encode($request->all()));
        \Log::info('Contenido bruto: ' . $request->getContent());
        // Validación
        $request->validate([
            'name' => 'nullable|string|max:255',
            'package' => 'nullable|string|max:255',
            'detail' => 'nullable|string',
            'sku' => 'nullable|integer|min:0',
            'cost' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'image' => 'nullable',
            'category' => 'required'
        ]);
    
        try {
            // Busca el producto
            $product = Product::findOrFail($id);
    
            // Actualiza los campos si están presentes en la solicitud
            foreach (['name', 'package', 'detail', 'sku', 'cost', 'quantity', 'category'] as $field) {
                if ($request->filled($field)) {
                    $product->$field = $request->input($field);
                }
            }
    
            // Manejo de imagen
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/images');
                $product->image = $path;
            }
    
            // Guarda los cambios
            $product->save();
    
            \Log::info("Producto actualizado correctamente: ", $product->toArray());
    
            return response()->json([
                'message' => 'Producto actualizado exitosamente',
                'product' => $product,
            ], 200);
        } catch (\Exception $e) {
            \Log::error("Error al actualizar producto: ", ['error' => $e->getMessage()]);
    
            return response()->json([
                'message' => 'Error al actualizar el producto',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();

            \Log::info("Producto eliminado correctamente: ID {$id}");

            return response()->json([
                'message' => 'Producto eliminado correctamente',
                'id' => $id
            ], 200);
        } catch (\Exception $e) {
            \Log::error("Error al eliminar el producto: {$e->getMessage()}");

            return response()->json([
                'message' => 'Error al eliminar el producto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function obtenerIdPorNombre(Request $request)
{
    // Validar la solicitud
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
    ]);

    // Buscar el producto por su nombre
    $producto = Product::where('name', $validatedData['nombre'])->first();

    if (!$producto) {
        return response()->json(['message' => 'Producto no encontrado'], 404);
    }

    return response()->json(['productoid' => $producto->id, 'precio' => $producto->cost], 200);
}

}
