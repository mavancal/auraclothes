<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->tieneNivel(50) ?? false;
    }

    public function rules(): array
    {
        return [
            'sku' => ['required', 'string', 'max:50', 'unique:productos,sku'],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'imagen_url' => ['nullable', 'string', 'max:255'],
            'precio' => ['required', 'numeric', 'min:0'],
            'precio_oferta' => ['nullable', 'numeric', 'min:0', 'lte:precio'],
            'stock' => ['nullable', 'integer', 'min:0', 'max:100000'],
            'categoria_id' => ['required', 'exists:categorias_producto,id'],
            'coleccion_id' => ['nullable', 'exists:colecciones,id'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'sku' => 'SKU',
            'nombre' => 'nombre',
            'descripcion' => 'descripción',
            'imagen_url' => 'URL de imagen',
            'precio' => 'precio',
            'precio_oferta' => 'precio de oferta',
            'stock' => 'stock',
            'categoria_id' => 'categoría',
            'coleccion_id' => 'colección',
        ];
    }
}
