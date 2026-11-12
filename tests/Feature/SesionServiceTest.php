<?php

namespace Tests\Feature;

use App\Exceptions\SesionInvalidaException;
use App\Models\User;
use App\Services\SesionService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SesionServiceTest extends TestCase
{
    use RefreshDatabase;

    private SesionService $servicio;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);
        $this->servicio = app(SesionService::class);
        $this->user = User::factory()->create([
            'email'    => 'maria@mail.com',
            'password' => 'secreto123',
        ]);
    }

    public function test_inicia_sesion_y_guarda_ultimo_acceso(): void
    {
        $this->assertNull($this->user->ultimo_acceso);

        $this->servicio->iniciar('maria@mail.com', 'secreto123');

        $this->assertAuthenticatedAs($this->user);
        $this->assertNotNull($this->user->fresh()->ultimo_acceso);
    }

    public function test_contrasena_incorrecta_no_inicia_sesion(): void
    {
        try {
            $this->servicio->iniciar('maria@mail.com', 'otra-cosa');
            $this->fail('Se esperaba SesionInvalidaException');
        } catch (SesionInvalidaException $e) {
            $this->assertSame('Correo o contraseña incorrectos.', $e->getMessage());
        }

        $this->assertGuest();
    }

    public function test_correo_inexistente_da_el_mismo_mensaje(): void
    {
        $this->expectException(SesionInvalidaException::class);
        $this->expectExceptionMessage('Correo o contraseña incorrectos.');

        $this->servicio->iniciar('nadie@mail.com', 'secreto123');
    }

    public function test_usuario_inactivo_no_puede_entrar(): void
    {
        $this->user->update(['activo' => false]);

        try {
            $this->servicio->iniciar('maria@mail.com', 'secreto123');
            $this->fail('Se esperaba SesionInvalidaException');
        } catch (SesionInvalidaException $e) {
            $this->assertStringContainsString('desactivada', $e->getMessage());
        }

        $this->assertGuest();
    }

    public function test_cerrar_sesion(): void
    {
        $this->servicio->iniciar('maria@mail.com', 'secreto123');
        $this->servicio->cerrar();

        $this->assertGuest();
    }
}