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
        return $this->belongsToMany(CategoriaUsuario::class, 'categoria_us_contacto', 'contacto_id', 'categoria_us_id')
                    ->withPivot('fecha_asig');
    }

    protected $fillable = [
        'nombre', 'nombre2', 'apellido', 'tipo_documento_id', 'numero_documento',
        'cuit', 'fecha_nacimiento', 'telefono', 'email_contacto', 'tipo_persona_id',
    ];

    protected function casts(): array
    {
        return ['fecha_nacimiento' => 'date'];
    }
}
