<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function storeProducto(StoreProductoRequest $request)
    {
        $validated = $request->validated();

        $producto = Producto::create([
            'sku' => $validated['sku'],
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'imagen_url' => $validated['imagen_url'] ?? null,
            'activo' => $request->boolean('activo'),
            'precio' => $validated['precio'],
            'precio_oferta' => $validated['precio_oferta'] ?? null,
            'stock' => $validated['stock'] ?? 0,
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

    public function updateProducto(Producto $producto, UpdateProductoRequest $request)
    {
        $validated = $request->validated();

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

        // Si el formulario manda el stock, se actualiza; si no lo manda, queda como estaba.
        if ($request->filled('stock')) {
            $producto->update(['stock'=> $validated['stock']]);
        }

        $producto->categorias()->sync([$validated['categoria_id']]);

        return redirect()->route('panel_productos_admin')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroyProducto(Producto $producto)
    {
        if ($producto->detalles()->exists()) {
            return redirect()->route('panel_productos_admin')->with('error', 'No se pudo eliminar el producto (tiene pedidos asociados). Podés desactivarlo.');
        }

        try {
            DB::transaction(function () use ($producto) {
                $producto->categorias()->detach();
                $producto->delete();
            });
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