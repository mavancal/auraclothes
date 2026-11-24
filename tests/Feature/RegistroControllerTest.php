<?php

namespace Tests\Feature;

use App\Models\Localidad;
use App\Models\Provincia;
use App\Models\TipoDocumento;
use App\Models\TipoPersona;
use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistroControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);
    }

    /** Lo que manda el formulario de registro completo y bien cargado. */
    private function formulario(array $cambios = []): array
    {
        $localidad = Localidad::query()->first();

        return array_merge([
            'name'                  => 'mariagomez',
            'email'                 => 'maria@mail.com',
            'password'              => 'secreto123',
            'password_confirmation' => 'secreto123',
            'nombre'                => 'María',
            'apellido'              => 'Gómez',
            'fecha_nacimiento'      => '1995-05-20',
            'tipo_persona_id'       => TipoPersona::query()->value('id'),
            'cuit'                  => '27-40123456-5',
            'tipo_documento_id'     => TipoDocumento::query()->value('id'),
            'numero_documento'      => '40123456',
            'telefono'              => '3764123456',
            'email_contacto'        => 'maria@mail.com',
            'provincia_id'          => $localidad->provincia_id,
            'localidad_id'          => $localidad->id,
            'calle'                 => 'Av. Uruguay',
            'numero'                => '1234',
        ], $cambios);
    }

    private function enviar(array $cambios = [])
    {
        return $this->from(route('registro'))->post(route('registro.store'), $this->formulario($cambios));
    }

    public function test_muestra_el_formulario(): void
    {
        $this->get(route('registro'))->assertOk();
    }

    public function test_registra_y_guarda_el_cuit_sin_guiones(): void
    {
        $this->enviar()
            ->assertRedirect(route('inicio'))
            ->assertSessionHas('success');

        $user = User::where('email', 'maria@mail.com')->firstOrFail();
        $this->assertSame('27401234565', $user->contacto->cuit);
        $this->assertAuthenticatedAs($user);
    }

    public function test_cuit_con_menos_digitos_da_error(): void
    {
        $this->enviar(['cuit' => '27-4012345-5'])->assertSessionHasErrors('cuit');

        $this->assertSame(0, User::count());
    }

    public function test_localidad_de_otra_provincia_da_error(): void
    {
        $otraProvincia = Provincia::where('id', '!=', Localidad::query()->value('provincia_id'))->value('id');

        $this->enviar(['provincia_id' => $otraProvincia])
            ->assertSessionHasErrors(['localidad_id' => 'La localidad no pertenece a la provincia seleccionada.']);
    }

    public function test_los_errores_usan_los_nombres_en_espanol(): void
    {
        $this->enviar(['name' => '', 'password_confirmation' => 'otra-cosa']);

        $errores = session('errors');
        $this->assertStringContainsString('nombre de usuario', $errores->first('name'));
        $this->assertStringContainsString('contraseña', $errores->first('password'));
    }

    public function test_si_hay_un_error_el_formulario_conserva_lo_escrito(): void
    {
        $this->followingRedirects()
            ->from(route('registro'))
            ->post(route('registro.store'), $this->formulario(['cuit' => '123'])) // CUIT inválido
            ->assertOk()
            ->assertSee('value="mariagomez"', false)
            ->assertSee('value="Av. Uruguay"', false)
            ->assertDontSee('value="secreto123"', false); // la contraseña nunca vuelve
    }

    public function test_registro_tiene_rate_limiting(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->withServerVariables(['REMOTE_ADDR' => '192.168.1.1'])
                ->post(route('registro.store'), []);
        }

        $this->withServerVariables(['REMOTE_ADDR' => '192.168.1.1'])
            ->post(route('registro.store'), [])
            ->assertStatus(429);
    }
}