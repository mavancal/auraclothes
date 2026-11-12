<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use App\Services\CatalogoService;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request, CatalogoService $catalogo)
    {
        // Filtros que llegan por la URL: /productos?q=remera&en_oferta=1&orden=precio_asc
        $filtros = [
            'q'            => $request->string('q')->trim()->limit(100, '')->value(),
            'coleccion_id' => $request->integer('coleccion_id') ?: null,
            'categoria_id' => $request->integer('categoria_id') ?: null,
            'en_oferta'    => $request->boolean('en_oferta'),
            'con_stock'    => $request->boolean('con_stock'),
            'orden'        => $request->string('orden')->value(),
        ];

        return view('productos', [
            'productos'   => $catalogo->buscar($filtros),
            'categorias'  => CategoriaProducto::orderBy('nombre_categoria')->get(),
            'colecciones' => Coleccion::orderBy('nombre_coleccion')->get(),
            'filtros'     => $filtros,
        ]);
    }
}