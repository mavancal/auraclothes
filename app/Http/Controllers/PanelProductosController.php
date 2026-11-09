<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use App\Models\Producto;
use Illuminate\Http\Request;

class PanelProductosController extends Controller
{
    public function index()
    {
        return view('vistas_admin.panel_productos_admin', [
            'categorias' => CategoriaProducto::orderBy('nombre_categoria')->get(),
            'colecciones' => Coleccion::orderBy('nombre_coleccion')->get(),
        ]);
    }

    public function storeProducto(Request $request)
    {
        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:50', 'unique:productos,sku'],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'imagen_url' => ['nullable', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0'],
            'precio_oferta' => ['nullable', 'numeric', 'min:0', 'lte:precio'],
            'categoria_id' => ['required', 'exists:categorias_producto,id'],
            'coleccion_id' => ['nullable', 'exists:colecciones,id'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $producto = Producto::create([
            'sku' => $validated['sku'],
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'imagen_url' => $validated['imagen_url'] ?? null,
            'activo' => $request->boolean('activo'),
            'precio' => $validated['precio'],
            'precio_oferta' => $validated['precio_oferta'] ?? null,
            'coleccion_id' => $validated['coleccion_id'] ?? null,
        ]);

        $producto->categorias()->attach($validated['categoria_id']);

        return redirect()->route('panel_productos_admin')->with('success', 'Producto guardado correctamente.');
    }

    public function storeColeccion(Request $request)
    {
        $validated = $request->validate([
            'nombre_coleccion' => ['required', 'string', 'max:255', 'unique:colecciones,nombre_coleccion'],
        ]);

        Coleccion::create($validated);

        return redirect()->route('panel_productos_admin')->with('success', 'Colección creada correctamente.');
    }

    public function storeCategoria(Request $request)
    {
        $validated = $request->validate([
            'nombre_categoria' => ['required', 'string', 'max:255', 'unique:categorias_producto,nombre_categoria'],
        ]);

        CategoriaProducto::create($validated);

        return redirect()->route('panel_productos_admin')->with('success', 'Categoría creada correctamente.');
    }
}