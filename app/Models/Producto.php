<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Producto extends Model
{
    protected $guarded = [];
    public function coleccion() { 
        return $this->belongsTo(Coleccion::class); 
    }
    public function categorias() {
        return $this->belongsToMany(CategoriaProducto::class, 'categoria_producto_producto');
    }
    public function detalles() { 
        return $this->hasMany(DetallePedido::class); 
    }
    
    protected $fillable = [
    'sku', 'nombre', 'descripcion', 'imagen_url', 'activo',
    'precio', 'precio_oferta', 'stock', 'coleccion_id',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'precio' => 'decimal:2',
            'precio_oferta' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeEnOferta($query)
    {
        return $query->whereNotNull('precio_oferta');
    }

    public function scopeConStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeDeColeccion($query, $coleccionId)
    {
        return $query->where('coleccion_id', $coleccionId);
    }

    public function scopeDeCategoria($query, $categoriaId)
    {
        return $query->whereHas('categorias', fn ($q) => $q->where('categorias_producto.id', $categoriaId));
    }

    // Atributos calculados
    protected function precioFinal(): Attribute
    {
        return Attribute::get(fn () => $this->precio_oferta ?? $this->precio);
    }

    protected function porcentajeDescuento(): Attribute
    {
        return Attribute::get(function () {
            if ($this->precio_oferta === null || $this->precio <= 0) {
                return 0;
            }

            return (int) round((1 - $this->precio_oferta / $this->precio) * 100);
        });
    }
}
