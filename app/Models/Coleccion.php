<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coleccion extends Model
{
    protected $table = 'colecciones';
    protected $fillable = ['nombre_coleccion'];
    public function productos() { 
        return $this->hasMany(Producto::class); 
    }
}
