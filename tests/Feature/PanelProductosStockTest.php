<?php

namespace Tests\Feature;

use App\Models\CategoriaProducto;
use App\Models\Producto;
use App\Models\Rol;
use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelProductosStockTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach(Rol::where('nombre_rol', 'Administrador')->value('id'));
    }

    /** Lo que manda el formulario de producto del panel. */
    private function formulario(array $cambios = []): array
    {
        return array_merge([
            'sku'          => 'TEST-001',
            'nombre'       => 'Buzo de prueba',
            'precio'       => 30000,
            'categoria_id' => CategoriaProducto::query()->value('id'),
            'activo'       => '1',
        ], $cambios);
    }

    public function test_crear_un_producto_con_stock(): void
    {
        $this->actingAs($this->admin)
            ->post(route('panel_productos_admin.productos.store'), $this->formulario(['stock' => 15]));

        $this->assertSame(15, Producto::where('sku', 'TEST-001')->value('stock'));
    }

    public function test_sin_stock_se_crea_con_cero_como_antes(): void
    {
        $this->actingAs($this->admin)
            ->post(route('panel_productos_admin.productos.store'), $this->formulario());

        $this->assertSame(0, Producto::where('sku', 'TEST-001')->value('stock'));
    }

    public function test_editar_cambia_el_stock_si_viene(): void
    {
        $producto = Producto::factory()->create(['sku' => 'TEST-001', 'stock' => 5]);

        $this->actingAs($this->admin)
            ->put(route('panel_productos_admin.productos.update', $producto), $this->formulario(['stock' => 40]));

        $this->assertSame(40, $producto->fresh()->stock);
    }

    public function test_editar_sin_stock_no_lo_borra(): void
    {
        $producto = Producto::factory()->create(['sku' => 'TEST-001', 'stock' => 5]);

        $this->actingAs($this->admin)
            ->put(route('panel_productos_admin.productos.update', $producto), $this->formulario(['nombre' => 'Nuevo nombre']));

        $this->assertSame('Nuevo nombre', $producto->fresh()->nombre);
        $this->assertSame(5, $producto->fresh()->stock);
    }

    public function test_no_acepta_stock_negativo(): void
    {
        $this->actingAs($this->admin)
            ->from(route('panel_productos_admin'))
            ->post(route('panel_productos_admin.productos.store'), $this->formulario(['stock' => -3]))
            ->assertSessionHasErrors('stock');

        $this->assertSame(0, Producto::count());
    }
}