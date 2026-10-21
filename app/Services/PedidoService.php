<?php

namespace App\Services;

use App\Exceptions\PedidoInvalidoException;
use App\Models\Direccion;
use App\Models\EstadoPedido;
use App\Models\MetodoPago;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PedidoService
{
    /**
     * Crea un pedido con su detalle y descuenta el stock.
     *
     * @param  array<int, array{producto_id: int, cantidad: int}>  $items
     *
     * @throws PedidoInvalidoException
     */
    public function crear(
        User $user,
        array $items,
        int $direccionId,
        int $metodoPagoId,
        float $costoEnvio = 0,
        float $descuento = 0,
    ): Pedido {
        $lineas = $this->unificarItems($items);

        return DB::transaction(function () use ($user, $lineas, $direccionId, $metodoPagoId, $costoEnvio, $descuento) {
            // 1. La dirección tiene que ser del usuario
            $direccion = Direccion::where('id', $direccionId)
                ->where('contacto_id', $user->contacto_id)
                ->first();

            if (! $direccion) {
                throw new PedidoInvalidoException('La dirección de envío no pertenece al usuario.');
            }

            // 2. El método de pago tiene que existir
            if (! MetodoPago::whereKey($metodoPagoId)->exists()) {
                throw new PedidoInvalidoException('El método de pago no existe.');
            }

            // 3. Traer los productos y bloquearlos hasta terminar la transacción
            $productos = Producto::whereIn('id', array_keys($lineas))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // 4. Validar cada línea y calcular el subtotal
            $subtotal = 0;

            foreach ($lineas as $productoId => $cantidad) {
                $producto = $productos->get($productoId);

                if (! $producto || ! $producto->activo) {
                    throw new PedidoInvalidoException("El producto {$productoId} no está disponible.");
                }

                if ($producto->stock < $cantidad) {
                    throw new PedidoInvalidoException(
                        "Stock insuficiente para \"{$producto->nombre}\": quedan {$producto->stock}."
                    );
                }

                $subtotal += $producto->precio_final * $cantidad;
            }

            if ($descuento > $subtotal) {
                throw new PedidoInvalidoException('El descuento no puede superar el subtotal.');
            }

            // 5. Crear el pedido y sus líneas, y descontar el stock
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'estado_pedido_id' => EstadoPedido::where('descripcion', EstadoPedido::PENDIENTE)->firstOrFail()->id,
                'descuento' => $descuento,
                'costo_envio' => $costoEnvio,
                'metodo_pago_id' => $metodoPagoId,
                'direccion_envio_id' => $direccion->id,
            ]);

            foreach ($lineas as $productoId => $cantidad) {
                $producto = $productos->get($productoId);

                $pedido->detalles()->create([
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio_final,
                ]);

                $producto->decrement('stock', $cantidad);
            }

            return $pedido->fresh(['detalles.producto']);
        });
    }

    /**
     * Valida los items y suma las cantidades si un producto viene repetido.
     *
     * @return array<int, int> [producto_id => cantidad]
     */
    private function unificarItems(array $items): array
    {
        if ($items === []) {
            throw new PedidoInvalidoException('El pedido no tiene productos.');
        }

        $lineas = [];

        foreach ($items as $item) {
            $productoId = (int) ($item['producto_id'] ?? 0);
            $cantidad = (int) ($item['cantidad'] ?? 0);

            if ($productoId <= 0 || $cantidad <= 0) {
                throw new PedidoInvalidoException('Cada producto necesita un id y una cantidad mayor a cero.');
            }

            $lineas[$productoId] = ($lineas[$productoId] ?? 0) + $cantidad;
        }

        return $lineas;
    }
}