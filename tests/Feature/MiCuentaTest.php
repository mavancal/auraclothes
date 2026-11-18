<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MiCuentaTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);
        $this->user = User::factory()->create(['password' => 'secreto123']);
    }

    private function cambiarPassword(array $datos)
    {
        return $this->actingAs($this->user)
            ->from(route('mi-cuenta'))
            ->put(route('mi-cuenta.password'), $datos);
    }

    public function test_un_visitante_es_mandado_al_login(): void
    {
        $this->get(route('mi-cuenta'))->assertRedirect(route('cuenta'));
    }

    public function test_actualiza_los_datos_permitidos_y_no_los_demas(): void
    {
        $documentoOriginal = $this->user->contacto->numero_documento;
        $nombreOriginal = $this->user->contacto->nombre;

        $this->actingAs($this->user)
            ->from(route('mi-cuenta'))
            ->patch(route('mi-cuenta.datos'), [
                'telefono'         => '3764999888',
                'email_contacto'   => 'nuevo@mail.com',
                // Intento de cambiar datos que no se pueden editar:
                'nombre'           => 'Otro Nombre',
                'numero_documento' => '99999999',
            ])
            ->assertRedirect(route('mi-cuenta'))
            ->assertSessionHas('success');

        $contacto = $this->user->contacto->fresh();
        $this->assertSame('3764999888', $contacto->telefono);
        $this->assertSame('nuevo@mail.com', $contacto->email_contacto);
        $this->assertSame($nombreOriginal, $contacto->nombre);
        $this->assertSame($documentoOriginal, $contacto->numero_documento);
    }

    public function test_el_email_de_contacto_tiene_que_ser_valido(): void
    {
        $this->actingAs($this->user)
            ->from(route('mi-cuenta'))
            ->patch(route('mi-cuenta.datos'), ['email_contacto' => 'esto-no-es-un-correo'])
            ->assertSessionHasErrors('email_contacto');
    }

    public function test_cambia_la_contrasena_con_la_actual_correcta(): void
    {
        $this->cambiarPassword([
            'password_actual'       => 'secreto123',
            'password'              => 'nueva-clave-456',
            'password_confirmation' => 'nueva-clave-456',
        ])->assertSessionHas('success');

        $this->assertTrue(Hash::check('nueva-clave-456', $this->user->fresh()->password));
    }

    public function test_con_la_contrasena_actual_incorrecta_no_cambia(): void
    {
        $this->cambiarPassword([
            'password_actual'       => 'me-la-olvide',
            'password'              => 'nueva-clave-456',
            'password_confirmation' => 'nueva-clave-456',
        ])->assertSessionHasErrors(['password_actual' => 'La contraseña actual no es correcta.']);

        $this->assertTrue(Hash::check('secreto123', $this->user->fresh()->password));
    }

    public function test_la_nueva_contrasena_tiene_que_estar_confirmada_y_ser_distinta(): void
    {
        $this->cambiarPassword([
            'password_actual'       => 'secreto123',
            'password'              => 'nueva-clave-456',
            'password_confirmation' => 'otra-cosa',
        ])->assertSessionHasErrors('password');

        $this->cambiarPassword([
            'password_actual'       => 'secreto123',
            'password'              => 'secreto123',
            'password_confirmation' => 'secreto123',
        ])->assertSessionHasErrors(['password' => 'La nueva contraseña tiene que ser distinta de la actual.']);
    }
}