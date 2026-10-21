<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    protected $guarded = [];
    public function pedido() { 
        return $this->belongsTo(Pedido::class); 
    }
    public function producto() { 
        return $this->belongsTo(Producto::class); 
    }

    protected $fillable = ['pedido_id', 'producto_id', 'cantidad', 'precio_unitario'];

    protected function casts(): array
    {
        return [
            'cantidad' => 'integer',
            'precio_unitario' => 'decimal:2',
        ];
    }
}
