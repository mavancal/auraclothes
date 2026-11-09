<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PanelProductosController extends Controller
{
    public function index()
    {
        return view('vistas_admin.panel_productos_admin', [
            'categorias' => CategoriaProducto::orderBy('nombre_categoria')->get(),
            'colecciones' => Coleccion::orderBy('nombre_coleccion')->get(),
            'productos' => Producto::with(['coleccion', 'categorias'])->orderBy('nombre')->get(),
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

    public function editProducto(Producto $producto)
    {
        return view('vistas_admin.panel_producto_editar', [
            'producto' => $producto,
            'categorias' => CategoriaProducto::orderBy('nombre_categoria')->get(),
            'colecciones' => Coleccion::orderBy('nombre_coleccion')->get(),
        ]);
    }

    public function updateProducto(Producto $producto, Request $request)
    {
        $validated = $request->validate([
            'sku' => ['required', 'string', 'max:50', Rule::unique('productos', 'sku')->ignore($producto->id)],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'imagen_url' => ['nullable', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0'],
            'precio_oferta' => ['nullable', 'numeric', 'min:0', 'lte:precio'],
            'categoria_id' => ['required', 'exists:categorias_producto,id'],
            'coleccion_id' => ['nullable', 'exists:colecciones,id'],
            'activo' => ['nullable', 'boolean'],
        ]);

        $producto->update([
            'sku' => $validated['sku'],
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'imagen_url' => $validated['imagen_url'] ?? null,
            'activo' => $request->boolean('activo'),
            'precio' => $validated['precio'],
            'precio_oferta' => $validated['precio_oferta'] ?? null,
            'coleccion_id' => $validated['coleccion_id'] ?? null,
        ]);

        $producto->categorias()->sync([$validated['categoria_id']]);

        return redirect()->route('panel_productos_admin')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroyProducto(Producto $producto)
    {
        try {
            $producto->categorias()->detach();
            $producto->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('panel_productos_admin')->with('error', 'No se pudo eliminar el producto (tiene pedidos asociados). Podés desactivarlo.');
        }

        return redirect()->route('panel_productos_admin')->with('success', 'Producto eliminado correctamente.');
    }

    public function updateColeccion(Coleccion $coleccion, Request $request)
    {
        $validated = $request->validate([
            'nombre_coleccion' => ['required', 'string', 'max:255', Rule::unique('colecciones', 'nombre_coleccion')->ignore($coleccion->id)],
        ]);

        $coleccion->update($validated);

        return redirect()->route('panel_productos_admin')->with('success', 'Colección actualizada correctamente.');
    }

    public function destroyColeccion(Coleccion $coleccion)
    {
        $coleccion->delete();

        return redirect()->route('panel_productos_admin')->with('success', 'Colección eliminada correctamente.');
    }

    public function updateCategoria(CategoriaProducto $categoriaProducto, Request $request)
    {
        $validated = $request->validate([
            'nombre_categoria' => ['required', 'string', 'max:255', Rule::unique('categorias_producto', 'nombre_categoria')->ignore($categoriaProducto->id)],
        ]);

        $categoriaProducto->update($validated);

        return redirect()->route('panel_productos_admin')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroyCategoria(CategoriaProducto $categoriaProducto)
    {
        $categoriaProducto->productos()->detach();
        $categoriaProducto->delete();

        return redirect()->route('panel_productos_admin')->with('success', 'Categoría eliminada correctamente.');
    }
}