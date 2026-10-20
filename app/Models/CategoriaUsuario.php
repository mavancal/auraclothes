<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaUsuario extends Model
{
    protected $table = 'categorias_us';
    protected $guarded = [];
    public function contactos()
    {
        return $this->belongsToMany(Contacto::class, 'categoria_us_contacto', 'categoria_us_id', 'contacto_id')
                    ->withPivot('fecha_asig');
    }
}
