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
}