<?php

namespace Tests\Feature;

use App\Models\Direccion;
use App\Models\MetodoPago;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use App\Services\CarritoService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Direccion $direccion;
    private Producto $producto;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);

        $this->user = User::factory()->create();
        $this->direccion = Direccion::factory()->create(['contacto_id' => $this->user->contacto_id]);
        $this->producto = Producto::factory()->create(['stock' => 10]);
    }

    /** Lo que manda el formulario de checkout. */
    private function datosCheckout(array $cambios = []): array
    {
        return array_merge([
            'direccion_id'   => $this->direccion->id,
            'metodo_pago_id' => MetodoPago::query()->value('id'),
        ], $cambios);
    }

    private function agregarAlCarrito(int $cantidad): void
    {
        $this->actingAs($this->user)
            ->post(route('carrito.agregar'), ['producto_id' => $this->producto->id, 'cantidad' => $cantidad]);
    }

    private function cantidadEnCarrito(): int
    {
        return app(CarritoService::class)->cantidadTotal();
    }

    public function test_un_visitante_es_mandado_al_login(): void
    {
        $this->post(route('checkout.confirmar'), $this->datosCheckout())
            ->assertRedirect(route('cuenta'));

        $this->assertSame(0, Pedido::count());
    }

    public function test_confirmar_crea_el_pedido_descuenta_stock_y_vacia_el_carrito(): void
    {
        $this->agregarAlCarrito(3);

        $this->post(route('checkout.confirmar'), $this->datosCheckout())
            ->assertRedirect(route('inicio'))
            ->assertSessionHas('success');

        $pedido = Pedido::sole();
        $this->assertTrue($pedido->user->is($this->user));
        $this->assertSame(3, $pedido->detalles->first()->cantidad);
        $this->assertSame(7, $this->producto->fresh()->stock);
        $this->assertSame(0, $this->cantidadEnCarrito());
    }

    public function test_con_el_carrito_vacio_no_se_crea_nada(): void
    {
        $this->actingAs($this->user)
            ->from(route('checkout'))
            ->post(route('checkout.confirmar'), $this->datosCheckout())
            ->assertRedirect(route('checkout'))
            ->assertSessionHasErrors(['checkout' => 'El pedido no tiene productos.']);

        $this->assertSame(0, Pedido::count());
    }

    public function test_una_direccion_ajena_no_crea_el_pedido_y_conserva_el_carrito(): void
    {
        $ajena = Direccion::factory()->create(); // de otro contacto
        $this->agregarAlCarrito(2);

        $this->from(route('checkout'))
            ->post(route('checkout.confirmar'), $this->datosCheckout(['direccion_id' => $ajena->id]))
            ->assertSessionHasErrors('checkout');

        $this->assertSame(0, Pedido::count());
        $this->assertSame(2, $this->cantidadEnCarrito());
    }

    public function test_si_el_stock_bajo_mientras_tanto_avisa_y_conserva_el_carrito(): void
    {
        $this->agregarAlCarrito(5);
        $this->producto->update(['stock' => 2]); // otro cliente compró antes

        $this->from(route('checkout'))
            ->post(route('checkout.confirmar'), $this->datosCheckout())
            ->assertSessionHasErrors('checkout');

        $this->assertSame(0, Pedido::count());
        $this->assertSame(2, $this->producto->fresh()->stock);
        $this->assertSame(5, $this->cantidadEnCarrito());
    }

        public function test_un_metodo_de_pago_inexistente_da_error_en_su_campo(): void
    {
        $this->agregarAlCarrito(1);

        $this->from(route('checkout'))
            ->post(route('checkout.confirmar'), $this->datosCheckout(['metodo_pago_id' => 999999]))
            ->assertSessionHasErrors('metodo_pago_id');

        $this->assertSame(0, Pedido::count());
        $this->assertStringContainsString('método de pago', session('errors')->first('metodo_pago_id'));
    }
}