<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model
{
    protected $table = 'estados_pedido';
    protected $guarded = [];
    public function pedidos() { 
        return $this->hasMany(Pedido::class); 
    }
}
