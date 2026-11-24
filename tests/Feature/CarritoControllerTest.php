<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Services\CarritoService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CarritoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);
    }

    private function cantidadEnCarrito(): int
    {
        return app(CarritoService::class)->cantidadTotal();
    }

    public function test_agregar_vuelve_a_la_pagina_anterior_con_mensaje(): void
    {
        $producto = Producto::factory()->create();

        $this->from(route('productos'))
            ->post(route('carrito.agregar'), ['producto_id' => $producto->id, 'cantidad' => 2])
            ->assertRedirect(route('productos'))
            ->assertSessionHas('success');

        $this->assertSame(2, $this->cantidadEnCarrito());
    }

    public function test_agregar_sin_stock_vuelve_con_el_error(): void
    {
        $producto = Producto::factory()->create(['stock' => 1]);

        $this->from(route('productos'))
            ->post(route('carrito.agregar'), ['producto_id' => $producto->id, 'cantidad' => 5])
            ->assertRedirect(route('productos'))
            ->assertSessionHasErrors('carrito');

        $this->assertSame(0, $this->cantidadEnCarrito());
    }

    public function test_actualizar_y_quitar(): void
    {
        $producto = Producto::factory()->create();
        $this->post(route('carrito.agregar'), ['producto_id' => $producto->id, 'cantidad' => 3]);

        $this->patch(route('carrito.actualizar', $producto->id), ['cantidad' => 1]);
        $this->assertSame(1, $this->cantidadEnCarrito());

        $this->delete(route('carrito.quitar', $producto->id));
        $this->assertSame(0, $this->cantidadEnCarrito());
    }

    public function test_vaciar(): void
    {
        $producto = Producto::factory()->create();
        $this->post(route('carrito.agregar'), ['producto_id' => $producto->id]);

        $this->delete(route('carrito.vaciar'))->assertSessionHas('success');

        $this->assertSame(0, $this->cantidadEnCarrito());
    }
    
    public function test_el_carrito_vacio_muestra_el_mensaje(): void
    {
        $this->get(route('carrito'))
            ->assertOk()
            ->assertSee('Tu carrito está vacío')
            ->assertDontSee('Finalizar compra');
    }

    public function test_el_header_muestra_el_contador_del_carrito(): void
    {
        $producto = Producto::factory()->create();

        $this->withSession(['carrito' => [$producto->id => 3]])
            ->get(route('inicio'))
            ->assertOk()
            ->assertSee('icon-btn__badge', false)
            ->assertSee('3');
    }
}