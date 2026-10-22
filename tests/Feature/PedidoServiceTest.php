<?php

namespace Tests\Feature;

use App\Exceptions\PedidoInvalidoException;
use App\Models\Direccion;
use App\Models\EstadoPedido;
use App\Models\Producto;
use App\Models\User;
use App\Services\PedidoService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PedidoServiceTest extends TestCase
{
    use RefreshDatabase;

    private PedidoService $servicio;
    private User $user;
    private Direccion $direccion;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);

        $this->user = User::factory()->create();
        $this->direccion = Direccion::factory()->create([
            'contacto_id' => $this->user->contacto_id,
        ]);
        $this->servicio = app(PedidoService::class);
    }

    public function test_crea_pedido_descuenta_stock_y_usa_precio_de_oferta(): void
    {
        $normal = Producto::factory()->create(['precio' => 10000, 'stock' => 10]);
        $oferta = Producto::factory()->enOferta(8000)->create(['precio' => 10000, 'stock' => 10]);

        $pedido = $this->servicio->crear($this->user, [
            ['producto_id' => $normal->id, 'cantidad' => 2],
            ['producto_id' => $oferta->id, 'cantidad' => 1],
        ], $this->direccion->id, 1, 500);

        $this->assertSame(28500.0, (float) $pedido->total()); // 20000 + 8000 + 500
        $this->assertSame(8, $normal->fresh()->stock);
        $this->assertSame(9, $oferta->fresh()->stock);
    }

    public function test_sin_stock_lanza_excepcion_y_no_guarda_nada(): void
    {
        $producto = Producto::factory()->create(['stock' => 2]);

        try {
            $this->servicio->crear($this->user, [
                ['producto_id' => $producto->id, 'cantidad' => 5],
            ], $this->direccion->id, 1);
            $this->fail('Tendría que haber lanzado PedidoInvalidoException');
        } catch (PedidoInvalidoException) {
            // esperado
        }

        $this->assertDatabaseCount('pedidos', 0);
        $this->assertSame(2, $producto->fresh()->stock);
    }

    public function test_rechaza_direccion_de_otro_usuario(): void
    {
        $producto = Producto::factory()->create();
        $ajena = Direccion::factory()->create(); // pertenece a otro contacto

        $this->expectException(PedidoInvalidoException::class);

        $this->servicio->crear($this->user, [
            ['producto_id' => $producto->id, 'cantidad' => 1],
        ], $ajena->id, 1);
    }

    public function test_unifica_productos_repetidos_en_una_linea(): void
    {
        $producto = Producto::factory()->create(['stock' => 10]);

        $pedido = $this->servicio->crear($this->user, [
            ['producto_id' => $producto->id, 'cantidad' => 1],
            ['producto_id' => $producto->id, 'cantidad' => 2],
        ], $this->direccion->id, 1);

        $this->assertCount(1, $pedido->detalles);
        $this->assertSame(3, $pedido->detalles->first()->cantidad);
    }

    public function test_cancelar_devuelve_el_stock(): void
    {
        $producto = Producto::factory()->create(['stock' => 10]);

        $pedido = $this->servicio->crear($this->user, [
            ['producto_id' => $producto->id, 'cantidad' => 4],
        ], $this->direccion->id, 1);

        $this->assertSame(6, $producto->fresh()->stock);

        $this->servicio->cancelar($pedido);

        $this->assertSame(10, $producto->fresh()->stock);
    }

    public function test_no_se_puede_cancelar_dos_veces_ni_saltar_estados(): void
    {
        $producto = Producto::factory()->create(['stock' => 10]);

        $pedido = $this->servicio->crear($this->user, [
            ['producto_id' => $producto->id, 'cantidad' => 1],
        ], $this->direccion->id, 1);

        $this->servicio->cancelar($pedido);

        try {
            $this->servicio->cancelar($pedido);
            $this->fail('La segunda cancelación debería fallar');
        } catch (PedidoInvalidoException) {
            //
        }

        $this->assertSame(10, $producto->fresh()->stock); // no se sumó de más

        $otro = $this->servicio->crear($this->user, [
            ['producto_id' => $producto->id, 'cantidad' => 1],
        ], $this->direccion->id, 1);

        $this->expectException(PedidoInvalidoException::class);
        $this->servicio->cambiarEstado($otro, EstadoPedido::ENTREGADO); // Pendiente → Entregado
    }
}