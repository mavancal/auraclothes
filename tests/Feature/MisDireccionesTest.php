<?php

namespace Tests\Feature;

use App\Models\Direccion;
use App\Models\Localidad;
use App\Models\Provincia;
use App\Models\User;
use App\Services\DireccionService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\MetodoPago;
use App\Models\Producto;
use App\Services\PedidoService;

class MisDireccionesTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Direccion $casa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);

        $this->user = User::factory()->create();
        // Su primera dirección (queda principal sola)
        $this->casa = app(DireccionService::class)->agregar($this->user, [
            'calle'        => 'Av. Mitre',
            'numero'       => '100',
            'localidad_id' => Localidad::query()->value('id'),
        ]);
    }

    /** Lo que manda el formulario de "agregar dirección". */
    private function formulario(array $cambios = []): array
    {
        $localidad = Localidad::query()->first();

        return array_merge([
            'provincia_id' => $localidad->provincia_id,
            'localidad_id' => $localidad->id,
            'calle'        => 'San Martín',
            'numero'       => '500',
        ], $cambios);
    }

    private function agregar(array $cambios = [])
    {
        return $this->actingAs($this->user)
            ->from(route('mis-direcciones'))
            ->post(route('mis-direcciones.store'), $this->formulario($cambios));
    }

    /** La calle de la dirección principal del usuario. */
    private function callePrincipal(): string
    {
        return Direccion::where('contacto_id', $this->user->contacto_id)
            ->where('es_principal', true)
            ->sole()
            ->calle;
    }

    public function test_un_visitante_es_mandado_al_login(): void
    {
        $this->post(route('mis-direcciones.store'), $this->formulario())
            ->assertRedirect(route('cuenta'));
    }

    public function test_agregar_una_direccion_sin_marcarla_mantiene_la_principal(): void
    {
        $this->agregar()
            ->assertRedirect(route('mis-direcciones'))
            ->assertSessionHas('success');

        $this->assertSame(2, Direccion::where('contacto_id', $this->user->contacto_id)->count());
        $this->assertSame('Av. Mitre', $this->callePrincipal());
    }

    public function test_agregar_como_principal_reemplaza_a_la_anterior(): void
    {
        $this->agregar(['es_principal' => '1']);

        $this->assertSame('San Martín', $this->callePrincipal());
    }

    public function test_la_localidad_tiene_que_ser_de_la_provincia(): void
    {
        $otraProvincia = Provincia::where('id', '!=', Localidad::query()->value('provincia_id'))->value('id');

        $this->agregar(['provincia_id' => $otraProvincia])
            ->assertSessionHasErrors(['localidad_id' => 'La localidad no pertenece a la provincia seleccionada.']);

        $this->assertSame(1, Direccion::where('contacto_id', $this->user->contacto_id)->count());
    }

    public function test_marcar_otra_direccion_como_principal(): void
    {
        $this->agregar();
        $trabajo = Direccion::where('calle', 'San Martín')->sole();

        $this->patch(route('mis-direcciones.principal', $trabajo->id))
            ->assertSessionHas('success');

        $this->assertSame('San Martín', $this->callePrincipal());
    }

    public function test_no_puede_marcar_la_direccion_de_otro(): void
    {
        $otro = User::factory()->create();
        $ajena = app(DireccionService::class)->agregar($otro, [
            'calle'        => 'Ajena',
            'numero'       => '1',
            'localidad_id' => Localidad::query()->value('id'),
        ]);

        $this->actingAs($this->user)
            ->from(route('mis-direcciones'))
            ->patch(route('mis-direcciones.principal', $ajena->id))
            ->assertSessionHasErrors(['direccion' => 'La dirección no pertenece al usuario.']);

        $this->assertSame('Av. Mitre', $this->callePrincipal());
        $this->assertTrue($ajena->fresh()->es_principal); // la del otro tampoco cambió
    }
    public function test_la_pagina_de_direcciones_carga(): void
    {
        $this->actingAs($this->user)
            ->get(route('mis-direcciones'))
            ->assertOk()
            ->assertSee('Av. Mitre');
    }

    public function test_editar_corrige_una_direccion_sin_pedidos(): void
    {
        $this->actingAs($this->user)
            ->get(route('mis-direcciones.edit', $this->casa->id))
            ->assertOk();

        $this->actingAs($this->user)
            ->from(route('mis-direcciones.edit', $this->casa->id))
            ->put(route('mis-direcciones.update', $this->casa->id), $this->formulario(['calle' => 'Av. Mitre Corregida']))
            ->assertRedirect(route('mis-direcciones'))
            ->assertSessionHas('success');

        $casa = $this->casa->fresh();
        $this->assertSame('Av. Mitre Corregida', $casa->calle);
        $this->assertTrue($casa->es_principal); // editar no cambia cuál es la principal
    }

    public function test_no_se_puede_editar_una_direccion_usada_en_un_pedido(): void
    {
        $producto = Producto::factory()->create(['stock' => 5]);
        app(PedidoService::class)->crear(
            $this->user,
            [['producto_id' => $producto->id, 'cantidad' => 1]],
            $this->casa->id,
            MetodoPago::query()->value('id'),
        );

        $this->actingAs($this->user)
            ->get(route('mis-direcciones.edit', $this->casa->id))
            ->assertRedirect(route('mis-direcciones'))
            ->assertSessionHasErrors(['direccion' => DireccionService::MENSAJE_USADA]);

        $this->actingAs($this->user)
            ->put(route('mis-direcciones.update', $this->casa->id), $this->formulario(['calle' => 'Otra']))
            ->assertSessionHasErrors('direccion');

        $this->assertSame('Av. Mitre', $this->casa->fresh()->calle);
    }

    public function test_no_se_puede_editar_la_direccion_de_otro(): void
    {
        $otro = User::factory()->create();
        $ajena = app(DireccionService::class)->agregar($otro, [
            'calle'        => 'Ajena',
            'numero'       => '1',
            'localidad_id' => Localidad::query()->value('id'),
        ]);

        $this->actingAs($this->user)
            ->put(route('mis-direcciones.update', $ajena->id), $this->formulario(['calle' => 'Robada']))
            ->assertSessionHasErrors(['direccion' => 'La dirección no pertenece al usuario.']);

        $this->assertSame('Ajena', $ajena->fresh()->calle);
    }

    public function test_eliminar_direccion_propia(): void
    {
        $segunda = app(DireccionService::class)->agregar($this->user, [
            'calle' => 'Segunda Calle',
            'numero' => '200',
            'localidad_id' => Localidad::query()->value('id'),
        ]);

        $this->actingAs($this->user)
            ->delete(route('mis-direcciones.destroy', $segunda->id))
            ->assertRedirect(route('mis-direcciones'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('direcciones', ['id' => $segunda->id]);
    }

    public function test_no_se_puede_eliminar_direccion_con_pedidos(): void
    {
        $producto = Producto::factory()->create(['stock' => 5]);
        app(PedidoService::class)->crear(
            $this->user,
            [['producto_id' => $producto->id, 'cantidad' => 1]],
            $this->casa->id,
            MetodoPago::query()->value('id'),
        );

        $this->actingAs($this->user)
            ->delete(route('mis-direcciones.destroy', $this->casa->id))
            ->assertRedirect(route('mis-direcciones'))
            ->assertSessionHasErrors(['direccion' => DireccionService::MENSAJE_ELIMINAR_USADA]);

        $this->assertDatabaseHas('direcciones', ['id' => $this->casa->id]);
    }

    public function test_no_se_puede_eliminar_la_direccion_de_otro(): void
    {
        $otro = User::factory()->create();
        $ajena = app(DireccionService::class)->agregar($otro, [
            'calle' => 'Ajena',
            'numero' => '1',
            'localidad_id' => Localidad::query()->value('id'),
        ]);

        $this->actingAs($this->user)
            ->delete(route('mis-direcciones.destroy', $ajena->id))
            ->assertRedirect(route('mis-direcciones'))
            ->assertSessionHasErrors(['direccion' => 'La dirección no pertenece al usuario.']);

        $this->assertDatabaseHas('direcciones', ['id' => $ajena->id]);
    }
}