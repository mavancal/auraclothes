<?php

namespace App\Services;

use App\Exceptions\CarritoInvalidoException;
use App\Models\Producto;
use Illuminate\Support\Collection;

class CarritoService
{
    /** Clave donde se guarda el carrito en la sesión: [producto_id => cantidad] */
    private const CLAVE = 'carrito';

    /**
     * Agrega unidades de un producto (si ya estaba, las suma).
     *
     * @throws CarritoInvalidoException
     */
    public function agregar(int $productoId, int $cantidad = 1): void
    {
        if ($cantidad < 1) {
            throw new CarritoInvalidoException('La cantidad tiene que ser al menos 1.');
        }

        $carrito = $this->leer();
        $nuevaCantidad = ($carrito[$productoId] ?? 0) + $cantidad;

        $this->validarStock($productoId, $nuevaCantidad);

        $carrito[$productoId] = $nuevaCantidad;
        $this->guardar($carrito);
    }

    /**
     * Cambia la cantidad de un producto que ya está en el carrito (0 = quitarlo).
     *
     * @throws CarritoInvalidoException
     */
    public function actualizar(int $productoId, int $cantidad): void
    {
        $carrito = $this->leer();

        if (! isset($carrito[$productoId])) {
            throw new CarritoInvalidoException('Ese producto no está en el carrito.');
        }

        if ($cantidad <= 0) {
            $this->quitar($productoId);

            return;
        }

        $this->validarStock($productoId, $cantidad);

        $carrito[$productoId] = $cantidad;
        $this->guardar($carrito);
    }

    public function quitar(int $productoId): void
    {
        $carrito = $this->leer();
        unset($carrito[$productoId]);
        $this->guardar($carrito);
    }

    public function vaciar(): void
    {
        session()->forget(self::CLAVE);
    }

    /**
     * Los renglones del carrito con el producto y los precios ACTUALES de la base.
     * Si un producto se desactivó o se borró, se saca del carrito.
     *
     * @return Collection<int, array{producto: Producto, cantidad: int, subtotal: float}>
     */
    public function items(): Collection
    {
        $carrito = $this->leer();

        $productos = Producto::activos()
            ->whereKey(array_keys($carrito))
            ->get()
            ->keyBy('id');

        // Limpiar los que ya no están disponibles
        $disponibles = array_intersect_key($carrito, $productos->all());
        if (count($disponibles) !== count($carrito)) {
            $this->guardar($disponibles);
        }

        return collect($disponibles)->map(fn (int $cantidad, int $id) => [
            'producto' => $productos[$id],
            'cantidad' => $cantidad,
            'subtotal' => (float) $productos[$id]->precio_final * $cantidad,
        ])->values();
    }

    public function subtotal(): float
    {
        return $this->items()->sum('subtotal');
    }

    /** Cantidad total de unidades (para el numerito del ícono del carrito). */
    public function cantidadTotal(): int
    {
        return array_sum($this->leer());
    }

    /**
     * El carrito en el formato que espera PedidoService::crear().
     *
     * @return array<int, array{producto_id: int, cantidad: int}>
     */
    public function paraPedido(): array
    {
        return $this->items()->map(fn ($item) => [
            'producto_id' => $item['producto']->id,
            'cantidad'    => $item['cantidad'],
        ])->all();
    }

    /**
     * @throws CarritoInvalidoException
     */
    private function validarStock(int $productoId, int $cantidad): void
    {
        $producto = Producto::activos()->find($productoId);

        if (! $producto) {
            throw new CarritoInvalidoException('El producto no está disponible.');
        }

        if ($cantidad > $producto->stock) {
            throw new CarritoInvalidoException(
                "Solo hay {$producto->stock} unidades de {$producto->nombre}."
            );
        }
    }

    /** @return array<int, int> */
    private function leer(): array
    {
        return session(self::CLAVE, []);
    }

    private function guardar(array $carrito): void
    {
        session([self::CLAVE => $carrito]);
    }
}