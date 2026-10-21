<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoPedido extends Model
{
    protected $table = 'estados_pedido';
    protected $fillable = ['descripcion'];
    public function pedidos() { 
        return $this->hasMany(Pedido::class); 
    }

    public const PENDIENTE = 'Pendiente';
    public const PAGADO = 'Pagado';
    public const EN_PREPARACION = 'En preparación';
    public const ENVIADO = 'Enviado';
    public const ENTREGADO = 'Entregado';
    public const CANCELADO = 'Cancelado';
}
