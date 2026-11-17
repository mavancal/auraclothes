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

class PanelPedidosTest extends TestCase
{
    use RefreshDatabase;

    private User $empleado;
    private Producto $producto;
    private Pedido $pedido;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);

        $this->empleado = $this->usuarioCon('Empleado');
        $this->producto = Producto::factory()->create(['stock' => 10]);

        // Un pedido real de un cliente: 3 unidades (el stock queda en 7)
        $cliente = $this->usuarioCon('Cliente');
        $direccion = Direccion::factory()->create(['contacto_id' => $cliente->contacto_id]);
        $this->pedido = app(PedidoService::class)->crear(
            $cliente,
            [['producto_id' => $this->producto->id, 'cantidad' => 3]],
            $direccion->id,
            MetodoPago::query()->value('id'),
        );
    }

    private function usuarioCon(string $nombreRol): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Rol::where('nombre_rol', $nombreRol)->value('id'));

        return $user;
    }

    private function estadoActual(): string
    {
        return $this->pedido->fresh()->estadoPedido->descripcion;
    }

    private function cambiarA(string $estado, ?User $como = null)
    {
        return $this->actingAs($como ?? $this->empleado)
            ->from(route('panel_pedidos_admin.show', $this->pedido))
            ->patch(route('panel_pedidos_admin.estado', $this->pedido), ['estado' => $estado]);
    }

    public function test_un_cliente_no_puede_entrar_ni_cambiar_estados(): void
    {
        $cliente = $this->usuarioCon('Cliente');

        $this->actingAs($cliente)->get(route('panel_pedidos_admin'))->assertForbidden();
        $this->cambiarA(EstadoPedido::PAGADO, $cliente)->assertForbidden();

        $this->assertSame(EstadoPedido::PENDIENTE, $this->estadoActual());
    }

    public function test_el_empleado_avanza_el_pedido_paso_a_paso(): void
    {
        foreach ([EstadoPedido::PAGADO, EstadoPedido::EN_PREPARACION, EstadoPedido::ENVIADO, EstadoPedido::ENTREGADO] as $estado) {
            $this->cambiarA($estado)
                ->assertRedirect(route('panel_pedidos_admin.show', $this->pedido))
                ->assertSessionHas('success');

            $this->assertSame($estado, $this->estadoActual());
        }
    }

    public function test_no_permite_saltear_estados(): void
    {
        $this->cambiarA(EstadoPedido::ENVIADO) // de Pendiente directo a Enviado
            ->assertSessionHasErrors(['estado' => 'No se puede pasar un pedido de "Pendiente" a "Enviado".']);

        $this->assertSame(EstadoPedido::PENDIENTE, $this->estadoActual());
    }

    public function test_cancelar_un_pedido_pagado_devuelve_el_stock(): void
    {
        $this->cambiarA(EstadoPedido::PAGADO);
        $this->assertSame(7, $this->producto->fresh()->stock);

        $this->cambiarA(EstadoPedido::CANCELADO)->assertSessionHas('success');

        $this->assertSame(EstadoPedido::CANCELADO, $this->estadoActual());
        $this->assertSame(10, $this->producto->fresh()->stock);
    }

    public function test_rechaza_un_estado_que_no_existe(): void
    {
        $this->cambiarA('Robado')->assertSessionHasErrors('estado');

        $this->assertSame(EstadoPedido::PENDIENTE, $this->estadoActual());
    }
}