<?php

namespace Tests\Feature;

use App\Exceptions\DireccionInvalidaException;
use App\Models\Direccion;
use App\Models\Localidad;
use App\Models\User;
use App\Services\DireccionService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DireccionServiceTest extends TestCase
{
    use RefreshDatabase;

    private DireccionService $servicio;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);
        $this->servicio = app(DireccionService::class);
        $this->user = User::factory()->create(); // su contacto arranca sin direcciones
    }

    private function datos(array $cambios = []): array
    {
        return array_merge([
            'calle'        => 'San Martín',
            'numero'       => '500',
            'localidad_id' => Localidad::query()->value('id'),
        ], $cambios);
    }

    /**
     * Cuántas direcciones principales tiene el contacto del usuario.
     */
    private function cantidadDePrincipales(): int
    {
        return Direccion::where('contacto_id', $this->user->contacto_id)
            ->where('es_principal', true)
            ->count();
    }

    public function test_la_primera_direccion_queda_principal_aunque_no_se_pida(): void
    {
        $direccion = $this->servicio->agregar($this->user, $this->datos(), false);

        $this->assertTrue($direccion->es_principal);
    }

    public function test_agregar_como_principal_desmarca_la_anterior(): void
    {
        $vieja = $this->servicio->agregar($this->user, $this->datos());
        $nueva = $this->servicio->agregar($this->user, $this->datos(['calle' => 'Bolívar']), true);

        $this->assertFalse($vieja->fresh()->es_principal);
        $this->assertTrue($nueva->fresh()->es_principal);
        $this->assertSame(1, $this->cantidadDePrincipales());
    }

    public function test_agregar_sin_principal_mantiene_la_anterior(): void
    {
        $vieja = $this->servicio->agregar($this->user, $this->datos());
        $nueva = $this->servicio->agregar($this->user, $this->datos(['calle' => 'Bolívar']));

        $this->assertTrue($vieja->fresh()->es_principal);
        $this->assertFalse($nueva->fresh()->es_principal);
        $this->assertSame(1, $this->cantidadDePrincipales());
    }

    public function test_marcar_como_principal_deja_una_sola(): void
    {
        $primera = $this->servicio->agregar($this->user, $this->datos());
        $segunda = $this->servicio->agregar($this->user, $this->datos(['calle' => 'Bolívar']));
        $tercera = $this->servicio->agregar($this->user, $this->datos(['calle' => 'Junín']));

        $this->servicio->marcarComoPrincipal($this->user, $tercera->id);

        $this->assertFalse($primera->fresh()->es_principal);
        $this->assertFalse($segunda->fresh()->es_principal);
        $this->assertTrue($tercera->fresh()->es_principal);
        $this->assertSame(1, $this->cantidadDePrincipales());
    }

    public function test_no_permite_marcar_una_direccion_ajena(): void
    {
        $mia = $this->servicio->agregar($this->user, $this->datos());

        $otroUsuario = User::factory()->create();
        $ajena = $this->servicio->agregar($otroUsuario, $this->datos());

        try {
            $this->servicio->marcarComoPrincipal($this->user, $ajena->id);
            $this->fail('Se esperaba DireccionInvalidaException');
        } catch (DireccionInvalidaException $e) {
            $this->assertSame('La dirección no pertenece al usuario.', $e->getMessage());
        }

        // No se tocó nada: la mía sigue siendo la principal
        $this->assertTrue($mia->fresh()->es_principal);
    }

    public function test_no_permite_localidad_inexistente(): void
    {
        $this->expectException(DireccionInvalidaException::class);
        $this->expectExceptionMessage('La localidad elegida no existe.');

        $this->servicio->agregar($this->user, $this->datos(['localidad_id' => 999999]));
    }

    public function test_eliminar_direccion(): void
    {
        $dir1 = $this->servicio->agregar($this->user, $this->datos(['calle' => 'Dir 1']));
        $dir2 = $this->servicio->agregar($this->user, $this->datos(['calle' => 'Dir 2']));

        $this->servicio->eliminar($this->user, $dir2->id);

        $this->assertDatabaseMissing('direcciones', ['id' => $dir2->id]);
    }

    public function test_eliminar_direccion_principal_promueve_otra(): void
    {
        $dir1 = $this->servicio->agregar($this->user, $this->datos(['calle' => 'Dir 1']));
        $dir2 = $this->servicio->agregar($this->user, $this->datos(['calle' => 'Dir 2']));

        $this->assertTrue($dir1->fresh()->es_principal);

        $this->servicio->eliminar($this->user, $dir1->id);

        $this->assertDatabaseMissing('direcciones', ['id' => $dir1->id]);
        $this->assertTrue($dir2->fresh()->es_principal);
        $this->assertSame(1, $this->cantidadDePrincipales());
    }

    public function test_no_permite_eliminar_direccion_ajena(): void
    {
        $otroUsuario = User::factory()->create();
        $ajena = $this->servicio->agregar($otroUsuario, $this->datos());

        $this->expectException(DireccionInvalidaException::class);
        $this->expectExceptionMessage('La dirección no pertenece al usuario.');

        $this->servicio->eliminar($this->user, $ajena->id);
    }
}