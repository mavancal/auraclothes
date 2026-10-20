<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['coleccion', 'categorias'])
            ->where('activo', true)
            ->get();

        return view('productos.index', compact('productos'));
    }
}