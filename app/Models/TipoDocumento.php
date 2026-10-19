<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documento';
    protected $guarded = [];
    public function contactos() { 
        return $this->hasMany(Contacto::class); 
    }
}
