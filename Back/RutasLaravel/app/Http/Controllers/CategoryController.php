<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DB::table('products')->select('category')->distinct()->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        DB::table('categories')->insert(['name' => $request->name]);
        return response()->json(['message' => 'Categoría creada exitosamente.'], 201);
    }
}

