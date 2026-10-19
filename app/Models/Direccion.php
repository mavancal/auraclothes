<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $table = 'direcciones';
    protected $guarded = [];
    public function localidad() { 
        return $this->belongsTo(Localidad::class); 
    }

    public function contacto() { 
        return $this->belongsTo(Contacto::class); 
    }
    
    public function pedidos() { 
        return $this->hasMany(Pedido::class, 'direccion_envio_id'); 
    }
}
