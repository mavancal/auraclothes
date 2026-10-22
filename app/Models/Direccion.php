<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Direccion extends Model
{
    use HasFactory;

    protected $table = 'direcciones';
    public function localidad() { 
        return $this->belongsTo(Localidad::class); 
    }

    public function contacto() { 
        return $this->belongsTo(Contacto::class); 
    }
    
    public function pedidos() { 
        return $this->hasMany(Pedido::class, 'direccion_envio_id'); 
    }

    protected $fillable = [
        'calle', 'numero', 'piso', 'departamento', 'cod_postal',
        'es_principal', 'referencia', 'localidad_id', 'contacto_id',
    ];

    protected function casts(): array
    {
        return ['es_principal' => 'boolean'];
    }
}
