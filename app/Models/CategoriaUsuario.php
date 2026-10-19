<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaUsuario extends Model
{
    protected $table = 'categorias_us';
    protected $guarded = [];
    public function contactos()
    {
        return $this->belongsToMany(Contacto::class, 'categoria_us_contacto')
                    ->withPivot('fecha_asig');
    }
}
