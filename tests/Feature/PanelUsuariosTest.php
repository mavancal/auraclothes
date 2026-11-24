<?php

namespace Tests\Feature;

use App\Models\Rol;
use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PanelUsuariosTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $empleado;
    private User $cliente;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogosSeeder::class);

        $rolAdmin = Rol::where('nombre_rol', 'Administrador')->firstOrFail();
        $rolEmpleado = Rol::where('nombre_rol', 'Empleado')->firstOrFail();
        $rolCliente = Rol::where('nombre_rol', 'Cliente')->firstOrFail();

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach($rolAdmin->id);

        $this->empleado = User::factory()->create();
        $this->empleado->roles()->attach($rolEmpleado->id);

        $this->cliente = User::factory()->create();
        $this->cliente->roles()->attach($rolCliente->id);
    }

    public function test_administrador_puede_ver_panel_de_usuarios(): void
    {
        $this->actingAs($this->admin)
            ->get(route('panel_usuarios_admin'))
            ->assertOk()
            ->assertSee('Gestión de Usuarios y Personal');
    }

    public function test_empleado_no_puede_acceder_al_panel_de_usuarios(): void
    {
        $this->actingAs($this->empleado)
            ->get(route('panel_usuarios_admin'))
            ->assertForbidden();
    }

    public function test_cliente_no_puede_acceder_al_panel_de_usuarios(): void
    {
        $this->actingAs($this->cliente)
            ->get(route('panel_usuarios_admin'))
            ->assertForbidden();
    }

    public function test_administrador_crea_un_nuevo_empleado(): void
    {
        $rolEmpleado = Rol::where('nombre_rol', 'Empleado')->firstOrFail();

        $response = $this->actingAs($this->admin)
            ->post(route('panel_usuarios_admin.store'), [
                'name' => 'empleado_nuevo',
                'email' => 'nuevoemp@auraclothes.com',
                'password' => 'claveSegura123',
                'rol_id' => $rolEmpleado->id,
                'nombre' => 'Carlos',
                'apellido' => 'Pérez',
            ]);

        $response->assertRedirect(route('panel_usuarios_admin'))
            ->assertSessionHas('success');

        $user = User::where('email', 'nuevoemp@auraclothes.com')->firstOrFail();
        $this->assertTrue(Hash::check('claveSegura123', $user->password));
        $this->assertTrue($user->roles->contains($rolEmpleado->id));
        $this->assertTrue($user->tieneNivel(50));
    }

    public function test_administrador_cambia_el_rol_de_un_usuario(): void
    {
        $rolAdmin = Rol::where('nombre_rol', 'Administrador')->firstOrFail();

        $response = $this->actingAs($this->admin)
            ->patch(route('panel_usuarios_admin.rol', $this->empleado), [
                'rol_id' => $rolAdmin->id,
            ]);

        $response->assertRedirect(route('panel_usuarios_admin'))
            ->assertSessionHas('success');

        $this->assertTrue($this->empleado->fresh()->tieneNivel(100));
    }

    public function test_administrador_no_puede_quitarse_a_si_mismo_el_rol_admin(): void
    {
        $rolCliente = Rol::where('nombre_rol', 'Cliente')->firstOrFail();

        $response = $this->actingAs($this->admin)
            ->patch(route('panel_usuarios_admin.rol', $this->admin), [
                'rol_id' => $rolCliente->id,
            ]);

        $response->assertSessionHas('error');
        $this->assertTrue($this->admin->fresh()->tieneNivel(100));
    }

    public function test_administrador_puede_activar_y_desactivar_usuarios(): void
    {
        $this->assertTrue($this->cliente->activo);

        // Desactivar
        $this->actingAs($this->admin)
            ->patch(route('panel_usuarios_admin.activo', $this->cliente))
            ->assertRedirect(route('panel_usuarios_admin'))
            ->assertSessionHas('success');

        $this->assertFalse($this->cliente->fresh()->activo);

        // Reactivar
        $this->actingAs($this->admin)
            ->patch(route('panel_usuarios_admin.activo', $this->cliente))
            ->assertRedirect(route('panel_usuarios_admin'))
            ->assertSessionHas('success');

        $this->assertTrue($this->cliente->fresh()->activo);
    }

    public function test_administrador_no_puede_desactivar_su_propia_cuenta(): void
    {
        $this->actingAs($this->admin)
            ->patch(route('panel_usuarios_admin.activo', $this->admin))
            ->assertSessionHas('error');

        $this->assertTrue($this->admin->fresh()->activo);
    }

    public function test_empleado_no_puede_borrar_colecciones_o_categorias(): void
    {
        $coleccion = \App\Models\Coleccion::firstOrFail();

        $this->actingAs($this->empleado)
            ->delete(route('panel_productos_admin.colecciones.destroy', $coleccion))
            ->assertForbidden();
    }
}
