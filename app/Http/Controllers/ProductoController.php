<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with(['coleccion', 'categorias'])
            ->where('activo', true)
            ->get();

        return view('productos', [
        'productos' => $productos,
        'categorias' => CategoriaProducto::orderBy('nombre_categoria')->get(),
        'colecciones' => Coleccion::orderBy('nombre_coleccion')->get(),
    ]);
    }
}