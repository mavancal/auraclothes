<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class PaginaController extends Controller
{
    public function inicio()
    {
        // Ofertas con stock; si no hay ninguna, muestra los últimos productos
        $productos = Producto::activos()->enOferta()->conStock()
            ->with('coleccion')->latest()->take(4)->get();

        if ($productos->isEmpty()) {
            $productos = Producto::activos()->conStock()
                ->with('coleccion')->latest()->take(4)->get();
        }

        return view('inicio', compact('productos'));
    }

    public function nuevo()
    {
        $productos = Producto::activos()
            ->with('coleccion')->latest()->take(8)->get();

        return view('nuevo', compact('productos'));
    }
}