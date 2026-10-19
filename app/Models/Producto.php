<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
