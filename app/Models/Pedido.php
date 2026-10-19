<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $guarded = [];

    public function user() { 
        return $this->belongsTo(User::class); 
    }
    public function estadoPedido() { 
        return $this->belongsTo(EstadoPedido::class); 
    }
    public function metodoPago() { 
        return $this->belongsTo(MetodoPago::class); 
    }
    public function direccionEnvio() { 
        return $this->belongsTo(Direccion::class); 
    }
    public function detalles() { 
        return $this->hasMany(DetallePedido::class); 
    }

    public function subtotal()
    {
        return $this->detalles->sum(fn ($d) => $d->cantidad * $d->precio_unitario);
    }

    public function total()
    {
        return $this->subtotal() - $this->descuento + $this->costo_envio;
    }
}
