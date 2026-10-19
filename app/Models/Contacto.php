<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $guarded = [];
    public function tipoDocumento() { return $this->belongsTo(TipoDocumento::class); }
    public function tipoPersona() { return $this->belongsTo(TipoPersona::class); }
    public function direcciones() { return $this->hasMany(Direccion::class); }
    public function user() { return $this->hasOne(User::class); }
    public function categorias()
    {
        return $this->belongsToMany(CategoriaUsuario::class, 'categoria_us_contacto')
                    ->withPivot('fecha_asig');
    }
}
