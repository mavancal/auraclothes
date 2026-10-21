<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{
    protected $table = 'tipos_persona';
protected $fillable = ['descripcion'];
public function contactos() { 
    return $this->hasMany(Contacto::class); 
}
}
