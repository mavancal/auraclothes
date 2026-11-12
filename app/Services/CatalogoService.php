<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Pagination\LengthAwarePaginator;

class CatalogoService
{
    /** Órdenes que se aceptan en la URL (?orden=...) */
    public const ORDENES = ['nuevos', 'precio_asc', 'precio_desc', 'nombre'];

    /**
     * Busca productos activos aplicando los filtros que vengan.
     * Los filtros vacíos se ignoran.
     *
     * @param  array{q?: string, coleccion_id?: int, categoria_id?: int,
     *               en_oferta?: bool, con_stock?: bool, orden?: string}  $filtros
     */
    public function buscar(array $filtros = [], int $porPagina = 12): LengthAwarePaginator
    {
        $orden = in_array($filtros['orden'] ?? null, self::ORDENES, true)
            ? $filtros['orden']
            : 'nuevos';

        return Producto::query()
            ->with(['coleccion', 'categorias'])
            ->activos()
            ->when($filtros['q'] ?? null, function ($query, $texto) {
                $query->where(function ($q) use ($texto) {
                    $q->where('nombre', 'like', "%{$texto}%")
                      ->orWhere('descripcion', 'like', "%{$texto}%")
                      ->orWhere('sku', 'like', "%{$texto}%");
                });
            })
            ->when($filtros['coleccion_id'] ?? null, fn ($query, $id) => $query->deColeccion($id))
            ->when($filtros['categoria_id'] ?? null, fn ($query, $id) => $query->deCategoria($id))
            ->when($filtros['en_oferta'] ?? false, fn ($query) => $query->enOferta())
            ->when($filtros['con_stock'] ?? false, fn ($query) => $query->conStock())
            ->when($orden === 'nuevos', fn ($query) => $query->latest('id'))
            ->when($orden === 'precio_asc', fn ($query) => $query->orderByRaw('COALESCE(precio_oferta, precio) ASC'))
            ->when($orden === 'precio_desc', fn ($query) => $query->orderByRaw('COALESCE(precio_oferta, precio) DESC'))
            ->when($orden === 'nombre', fn ($query) => $query->orderBy('nombre'))
            ->paginate($porPagina)
            ->withQueryString();
    }
}