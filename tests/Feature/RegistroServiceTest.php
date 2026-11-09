<?php

namespace Tests\Feature;

use App\Exceptions\RegistroInvalidoException;
use App\Models\Contacto;
use App\Models\Localidad;
use App\Models\TipoDocumento;
use App\Models\TipoPersona;
use App\Models\User;
use App\Services\RegistroService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistroServiceTest extends TestCase
{
    use RefreshDatabase;

    private RegistroService $servicio;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);
        $this->servicio = app(RegistroService::class);
    }

    /**
     * Datos de un registro válido. Con $cambios pisamos solo lo que cada test necesita.
     */
    private function datosValidos(array $cambios = []): array
    {
        return array_merge([
            'name'              => 'mariagomez',
            'email'             => 'maria@mail.com',
            'password'          => 'secreto123',
            'nombre'            => 'María',
            'apellido'          => 'Gómez',
            'tipo_documento_id' => TipoDocumento::query()->value('id'),
            'numero_documento'  => '40123456',
            'cuit'              => '27-40123456-5',
            'tipo_persona_id'   => TipoPersona::query()->value('id'),
            'email_contacto'    => 'maria@mail.com',
            'calle'             => 'Av. Uruguay',
            'numero'            => '1234',
            'localidad_id'      => Localidad::query()->value('id'),
        ], $cambios);
    }

    public function test_registra_contacto_direccion_usuario_y_rol_cliente(): void
    {
        $user = $this->servicio->registrar($this->datosValidos());

        $this->assertSame('María', $user->contacto->nombre);
        $this->assertSame('27401234565', $user->contacto->cuit);

        $direcciones = $user->contacto->direcciones;
        $this->assertCount(1, $direcciones);
        $this->assertTrue($direcciones->first()->es_principal);

        $this->assertSame(['Cliente'], $user->roles->pluck('nombre_rol')->all());

        // La contraseña se guardó hasheada (una sola vez), no en texto plano
        $this->assertNotSame('secreto123', $user->password);
        $this->assertTrue(Hash::check('secreto123', $user->password));
    }

    public function test_cuit_vacio_se_guarda_como_null(): void
    {
        $user = $this->servicio->registrar($this->datosValidos(['cuit' => '']));

        $this->assertNull($user->contacto->cuit);
    }

    public function test_no_permite_correo_repetido_y_no_crea_nada(): void
    {
        User::factory()->create(['email' => 'maria@mail.com']);
        $contactosAntes = Contacto::count();

        try {
            $this->servicio->registrar($this->datosValidos());
            $this->fail('Se esperaba RegistroInvalidoException');
        } catch (RegistroInvalidoException $e) {
            $this->assertSame('Ya existe una cuenta con ese correo.', $e->getMessage());
        }

        $this->assertSame($contactosAntes, Contacto::count());
    }

    public function test_no_permite_documento_repetido(): void
    {
        Contacto::factory()->create([
            'tipo_documento_id' => TipoDocumento::query()->value('id'),
            'numero_documento'  => '40123456',
        ]);

        $this->expectException(RegistroInvalidoException::class);
        $this->expectExceptionMessage('Ya existe una cuenta con ese documento.');

        $this->servicio->registrar($this->datosValidos());
    }

    public function test_no_permite_localidad_inexistente(): void
    {
        $this->expectException(RegistroInvalidoException::class);
        $this->expectExceptionMessage('La localidad elegida no existe.');

        $this->servicio->registrar($this->datosValidos(['localidad_id' => 999999]));
    }
}