<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    protected $table = 'categorias_producto';
    protected $fillable = ['nombre_categoria'];
    public function productos() {
        return $this->belongsToMany(Producto::class, 'categoria_producto_producto');
    }
}
