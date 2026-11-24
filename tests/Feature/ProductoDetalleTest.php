<?php

namespace Tests\Feature;

use App\Models\Coleccion;
use App\Models\Producto;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoDetalleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogosSeeder::class);
    }

    public function test_muestra_detalle_de_producto_activo(): void
    {
        $coleccion = Coleccion::firstOrFail();
        $producto = Producto::factory()->create([
            'nombre' => 'Campera de Lino',
            'sku' => 'CAM-LIN-01',
            'precio' => 45000,
            'precio_oferta' => 38000,
            'stock' => 8,
            'activo' => true,
            'coleccion_id' => $coleccion->id,
            'descripcion' => 'Campera artesanal 100% lino.',
        ]);

        $this->get(route('productos.show', $producto))
            ->assertOk()
            ->assertSee('Campera de Lino')
            ->assertSee('CAM-LIN-01')
            ->assertSee('$38.000')
            ->assertSee('$45.000')
            ->assertSee('8 unidades')
            ->assertSee('Campera artesanal 100% lino.');
    }

    public function test_producto_inactivo_devuelve_404(): void
    {
        $producto = Producto::factory()->create([
            'activo' => false,
        ]);

        $this->get(route('productos.show', $producto))
            ->assertNotFound();
    }
}
