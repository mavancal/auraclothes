<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
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

    protected $fillable = [
        'user_id', 'estado_pedido_id', 'fecha_ped', 'descuento',
        'costo_envio', 'metodo_pago_id', 'direccion_envio_id',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ped' => 'datetime',
            'descuento' => 'decimal:2',
            'costo_envio' => 'decimal:2',
        ];
    }

    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
