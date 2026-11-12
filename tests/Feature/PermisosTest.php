<?php

namespace Tests\Feature;

use App\Models\Producto;
use App\Models\Rol;
use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermisosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class); // trae los roles
    }

    /**
     * Crea un usuario con el rol indicado ('Administrador', 'Empleado' o 'Cliente').
     */
    private function usuarioCon(string $nombreRol): User
    {
        $user = User::factory()->create();
        $user->roles()->attach(Rol::where('nombre_rol', $nombreRol)->value('id'));

        return $user;
    }

    public function test_un_visitante_es_mandado_al_login(): void
    {
        $this->get(route('panel_productos_admin'))
            ->assertRedirect(route('cuenta'));
    }

    public function test_un_cliente_no_puede_entrar_al_panel(): void
    {
        $this->actingAs($this->usuarioCon('Cliente'))
            ->get(route('panel_productos_admin'))
            ->assertForbidden();
    }

    public function test_un_cliente_no_puede_borrar_productos(): void
    {
        $producto = Producto::factory()->create();

        $this->actingAs($this->usuarioCon('Cliente'))
            ->delete(route('panel_productos_admin.productos.destroy', $producto))
            ->assertForbidden();

        $this->assertModelExists($producto);
    }

    public function test_un_empleado_puede_entrar_al_panel(): void
    {
        $this->actingAs($this->usuarioCon('Empleado'))
            ->get(route('panel_productos_admin'))
            ->assertOk();
    }

    public function test_un_administrador_puede_entrar_al_panel(): void
    {
        $this->actingAs($this->usuarioCon('Administrador'))
            ->get(route('panel_productos_admin'))
            ->assertOk();
    }

    public function test_con_sesion_iniciada_el_login_redirige_al_inicio(): void
    {
        $this->actingAs($this->usuarioCon('Cliente'))
            ->get(route('cuenta'))
            ->assertRedirect(route('inicio'));
    }
}