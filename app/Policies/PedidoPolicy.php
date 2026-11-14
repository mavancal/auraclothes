<?php

namespace App\Policies;

use App\Models\EstadoPedido;
use App\Models\Pedido;
use App\Models\User;

class PedidoPolicy
{
    /**
     * Empleados y administradores pueden todo con cualquier pedido.
     * Devolver null significa "no decido acá, seguí con el método que corresponda".
     */
    public function before(User $user): ?bool
    {
        return $user->tieneNivel(50) ? true : null;
    }

    /** Un cliente solo ve sus propios pedidos. */
    public function view(User $user, Pedido $pedido): bool
    {
        return (int) $pedido->user_id === (int) $user->id;
    }

    /** Un cliente solo cancela sus pedidos, y solo mientras están Pendientes (antes de pagar). */
    public function cancelar(User $user, Pedido $pedido): bool
    {
        return $this->view($user, $pedido)
            && $pedido->estadoPedido->descripcion === EstadoPedido::PENDIENTE;
    }
}