<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SesionControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);
        $this->user = User::factory()->create([
            'email'    => 'maria@mail.com',
            'password' => 'secreto123',
        ]);
    }

    public function test_muestra_el_formulario_de_login(): void
    {
        $this->get(route('cuenta'))->assertOk();
    }

    public function test_login_correcto_redirige_al_inicio(): void
    {
        $this->post(route('sesion.iniciar'), [
            'email'    => 'maria@mail.com',
            'password' => 'secreto123',
        ])->assertRedirect(route('inicio'));

        $this->assertAuthenticatedAs($this->user);
    }

    public function test_login_incorrecto_vuelve_con_error_y_mantiene_el_correo(): void
    {
        $this->from(route('cuenta'))
            ->post(route('sesion.iniciar'), [
                'email'    => 'maria@mail.com',
                'password' => 'otra-cosa',
            ])
            ->assertRedirect(route('cuenta'))
            ->assertSessionHasErrors(['email' => 'Correo o contraseña incorrectos.'])
            ->assertSessionHasInput('email', 'maria@mail.com');

        $this->assertGuest();
    }

    public function test_logout_cierra_la_sesion(): void
    {
        $this->actingAs($this->user)
            ->post(route('sesion.cerrar'))
            ->assertRedirect(route('inicio'));

        $this->assertGuest();
    }
}