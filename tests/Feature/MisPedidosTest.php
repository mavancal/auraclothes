<?php

namespace Tests\Feature;

use App\Models\Direccion;
use App\Models\EstadoPedido;
use App\Models\MetodoPago;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Rol;
use App\Models\User;
use App\Services\PedidoService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MisPedidosTest extends TestCase
{
    use RefreshDatabase;

    private User $cliente;
    private User $otroCliente;
    private Producto $producto;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);

        $this->cliente = User::factory()->create();
        $this->otroCliente = User::factory()->create();
        $this->producto = Producto::factory()->create(['stock' => 10]);
    }

    /** Crea un pedido real (con PedidoService) de 2 unidades para el usuario. */
    private function pedidoDe(User $user): Pedido
    {
        $direccion = Direccion::factory()->create(['contacto_id' => $user->contacto_id]);

        return app(PedidoService::class)->crear(
            $user,
            [['producto_id' => $this->producto->id, 'cantidad' => 2]],
            $direccion->id,
            MetodoPago::query()->value('id'),
        );
    }

    public function test_cada_cliente_puede_ver_solo_sus_pedidos(): void
    {
        $pedido = $this->pedidoDe($this->cliente);

        $this->assertTrue($this->cliente->can('view', $pedido));
        $this->assertFalse($this->otroCliente->can('view', $pedido));
    }

    public function test_un_empleado_puede_ver_cualquier_pedido(): void
    {
        $empleado = User::factory()->create();
        $empleado->roles()->attach(Rol::where('nombre_rol', 'Empleado')->value('id'));

        $this->assertTrue($empleado->can('view', $this->pedidoDe($this->cliente)));
    }

    public function test_ver_el_pedido_de_otro_da_prohibido(): void
    {
        $pedido = $this->pedidoDe($this->cliente);

        $this->actingAs($this->otroCliente)
            ->get(route('mis-pedidos.show', $pedido))
            ->assertForbidden();
    }

    public function test_un_visitante_es_mandado_al_login(): void
    {
        $this->get(route('mis-pedidos'))->assertRedirect(route('cuenta'));
    }

    public function test_el_cliente_cancela_su_pedido_pendiente_y_vuelve_el_stock(): void
    {
        $pedido = $this->pedidoDe($this->cliente);
        $this->assertSame(8, $this->producto->fresh()->stock);

        $this->actingAs($this->cliente)
            ->from(route('mis-pedidos'))
            ->post(route('mis-pedidos.cancelar', $pedido))
            ->assertRedirect(route('mis-pedidos'))
            ->assertSessionHas('success');

        $this->assertSame(EstadoPedido::CANCELADO, $pedido->fresh()->estadoPedido->descripcion);
        $this->assertSame(10, $this->producto->fresh()->stock);
    }

    public function test_no_puede_cancelar_el_pedido_de_otro(): void
    {
        $pedido = $this->pedidoDe($this->cliente);

        $this->actingAs($this->otroCliente)
            ->post(route('mis-pedidos.cancelar', $pedido))
            ->assertForbidden();

        $this->assertSame(EstadoPedido::PENDIENTE, $pedido->fresh()->estadoPedido->descripcion);
    }

    public function test_el_cliente_no_puede_cancelar_un_pedido_ya_pagado(): void
    {
        $pedido = $this->pedidoDe($this->cliente);
        app(PedidoService::class)->cambiarEstado($pedido, EstadoPedido::PAGADO);

        $this->actingAs($this->cliente)
            ->post(route('mis-pedidos.cancelar', $pedido))
            ->assertForbidden();

        $this->assertSame(EstadoPedido::PAGADO, $pedido->fresh()->estadoPedido->descripcion);
    }
}