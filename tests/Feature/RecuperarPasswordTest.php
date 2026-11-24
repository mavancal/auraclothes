<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class RecuperarPasswordTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogosSeeder::class);
    }

    public function test_muestra_formulario_de_recuperacion(): void
    {
        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('¿Olvidaste tu contraseña?');
    }

    public function test_solicita_enlace_para_correo_existente(): void
    {
        $user = User::factory()->create(['email' => 'cliente@ejemplo.com']);

        $response = $this->post(route('password.email'), [
            'email' => 'cliente@ejemplo.com',
        ]);

        $response->assertSessionHas('status');
    }

    public function test_solicita_enlace_para_correo_inexistente(): void
    {
        $response = $this->post(route('password.email'), [
            'email' => 'noexiste@ejemplo.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_restablece_contrasena_con_token_valido(): void
    {
        $user = User::factory()->create([
            'email' => 'cliente@ejemplo.com',
            'password' => Hash::make('antigua123'),
        ]);

        $token = Password::broker()->createToken($user);

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => 'cliente@ejemplo.com',
            'password' => 'nuevaPassword123',
            'password_confirmation' => 'nuevaPassword123',
        ]);

        $response->assertRedirect(route('cuenta'))
            ->assertSessionHas('success');

        $this->assertTrue(Hash::check('nuevaPassword123', $user->fresh()->password));
    }
}
