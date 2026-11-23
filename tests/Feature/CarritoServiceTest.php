<?php

namespace Tests\Feature;

use App\Exceptions\CarritoInvalidoException;
use App\Models\Direccion;
use App\Models\MetodoPago;
use App\Models\Producto;
use App\Models\User;
use App\Services\CarritoService;
use App\Services\PedidoService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarritoServiceTest extends TestCase
{
    use RefreshDatabase;

    private CarritoService $carrito;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);
        $this->carrito = app(CarritoService::class); // cada test arranca con la sesión vacía
    }

    public function test_agregar_suma_unidades_y_usa_el_precio_final(): void
    {
        $producto = Producto::factory()->enOferta(8000)->create(['precio' => 10000]);

        $this->carrito->agregar($producto->id, 2);
        $this->carrito->agregar($producto->id);

        $this->assertSame(3, $this->carrito->cantidadTotal());
        $this->assertEquals(24000, $this->carrito->subtotal()); // 3 x 8000 (oferta)
    }

    public function test_no_permite_superar_el_stock_sumando_lo_que_ya_habia(): void
    {
        $producto = Producto::factory()->create(['stock' => 3]);
        $this->carrito->agregar($producto->id, 2);

        try {
            $this->carrito->agregar($producto->id, 2); // 2 + 2 = 4 > 3
            $this->fail('Se esperaba CarritoInvalidoException');
        } catch (CarritoInvalidoException $e) {
            $this->assertStringContainsString('Solo hay 3 unidades', $e->getMessage());
        }

        $this->assertSame(2, $this->carrito->cantidadTotal()); // no cambió
    }

    public function test_no_permite_agregar_un_producto_inactivo(): void
    {
        $producto = Producto::factory()->create(['activo' => false]);

        $this->expectException(CarritoInvalidoException::class);
        $this->expectExceptionMessage('El producto no está disponible.');

        $this->carrito->agregar($producto->id);
    }

    public function test_actualizar_cambia_la_cantidad_y_con_cero_lo_quita(): void
    {
        $producto = Producto::factory()->create();
        $this->carrito->agregar($producto->id, 5);

        $this->carrito->actualizar($producto->id, 2);
        $this->assertSame(2, $this->carrito->cantidadTotal());

        $this->carrito->actualizar($producto->id, 0);
        $this->assertSame(0, $this->carrito->cantidadTotal());
    }

    public function test_no_permite_actualizar_un_producto_que_no_esta(): void
    {
        $producto = Producto::factory()->create();

        $this->expectException(CarritoInvalidoException::class);
        $this->expectExceptionMessage('Ese producto no está en el carrito.');

        $this->carrito->actualizar($producto->id, 2);
    }

    public function test_saca_del_carrito_los_productos_que_se_desactivaron(): void
    {
        $sigue = Producto::factory()->create(['nombre' => 'Sigue']);
        $baja = Producto::factory()->create(['nombre' => 'Se da de baja']);
        $this->carrito->agregar($sigue->id);
        $this->carrito->agregar($baja->id);

        $baja->update(['activo' => false]); // el admin lo desactiva desde el panel

        $nombres = $this->carrito->items()->map(fn ($item) => $item['producto']->nombre)->all();

        $this->assertSame(['Sigue'], $nombres);
        $this->assertSame(1, $this->carrito->cantidadTotal()); // también se limpió la sesión
    }

    public function test_el_carrito_se_convierte_en_un_pedido(): void
    {
        $user = User::factory()->create();
        $direccion = Direccion::factory()->create(['contacto_id' => $user->contacto_id]);
        $producto = Producto::factory()->create(['stock' => 10]);

        $this->carrito->agregar($producto->id, 4);

        $pedido = app(PedidoService::class)->crear(
            $user,
            $this->carrito->paraPedido(),
            $direccion->id,
            MetodoPago::query()->value('id'),
        );

        $this->assertCount(1, $pedido->detalles);
        $this->assertSame(4, $pedido->detalles->first()->cantidad);
        $this->assertSame(6, $producto->fresh()->stock); // el stock se descuenta recién en el pedido
    }

    public function test_el_envio_se_cobra_por_debajo_del_monto_y_es_gratis_desde_ahi(): void
    {
        config(['tienda.envio.costo' => 3500, 'tienda.envio.gratis_desde' => 80000]);
        $producto = Producto::factory()->create(['precio' => 10000, 'stock' => 20]);

        $this->carrito->agregar($producto->id, 2); // 20.000
        $this->assertEquals(3500, $this->carrito->costoEnvio());
        $this->assertEquals(23500, $this->carrito->total());

        $this->carrito->actualizar($producto->id, 8); // 80.000: justo el monto
        $this->assertEquals(0, $this->carrito->costoEnvio());
        $this->assertEquals(80000, $this->carrito->total());
    }

    public function test_el_carrito_vacio_no_cobra_envio(): void
    {
        $this->assertEquals(0, $this->carrito->costoEnvio());
    }
}