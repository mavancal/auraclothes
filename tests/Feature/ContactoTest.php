<?php

namespace Tests\Feature;

use App\Models\MensajeContacto;
use App\Models\Rol;
use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactoTest extends TestCase
{
    use RefreshDatabase;

    private function mensaje(array $cambios = []): array
    {
        return array_merge([
            'nombre'  => 'Ana García',
            'email'   => 'ana@mail.com',
            'asunto'  => 'Consulta por talles',
            'mensaje' => '¿La remera oversize viene en XL?',
        ], $cambios);
    }

    private function usuarioCon(string $nombreRol): User
    {
        $this->seed(CatalogosSeeder::class);
        $user = User::factory()->create();
        $user->roles()->attach(Rol::where('nombre_rol', $nombreRol)->value('id'));

        return $user;
    }

    public function test_enviar_el_formulario_guarda_el_mensaje(): void
    {
        $this->post(route('contacto.enviar'), $this->mensaje())
            ->assertRedirect(route('contacto'))
            ->assertSessionHas('contacto_enviado');

        $this->assertDatabaseHas('mensajes_contacto', ['email' => 'ana@mail.com', 'leido' => false]);
    }

    public function test_los_campos_son_obligatorios(): void
    {
        $this->from(route('contacto'))
            ->post(route('contacto.enviar'), $this->mensaje(['email' => 'no-es-correo', 'mensaje' => '']))
            ->assertSessionHasErrors(['email', 'mensaje']);

        $this->assertSame(0, MensajeContacto::count());
    }

    public function test_la_pagina_de_contacto_muestra_el_formulario_conectado(): void
    {
        $this->get(route('contacto'))
            ->assertOk()
            ->assertSee('action="' . route('contacto.enviar') . '"', false);
    }

    public function test_el_personal_ve_los_mensajes_y_los_marca_como_leidos(): void
    {
        $mensaje = MensajeContacto::create($this->mensaje());
        $empleado = $this->usuarioCon('Empleado');

        $this->actingAs($empleado)
            ->get(route('panel_mensajes_admin'))
            ->assertOk()
            ->assertSee('Consulta por talles');

        $this->actingAs($empleado)
            ->patch(route('panel_mensajes_admin.leido', $mensaje));

        $this->assertTrue($mensaje->fresh()->leido);
    }

    public function test_un_cliente_no_ve_los_mensajes(): void
    {
        $this->actingAs($this->usuarioCon('Cliente'))
            ->get(route('panel_mensajes_admin'))
            ->assertForbidden();
    }
}