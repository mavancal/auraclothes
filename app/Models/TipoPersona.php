<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{
    protected $table = 'tipos_persona';
protected $guarded = [];
public function contactos() { 
    return $this->hasMany(Contacto::class); 
}
}
