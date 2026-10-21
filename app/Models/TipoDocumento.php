<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documento';
    protected $fillable = ['descripcion'];
    public function contactos() { 
        return $this->hasMany(Contacto::class); 
    }
}
