<?php

namespace Tests\Feature;

use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use App\Models\DetallePedido;
use App\Models\EstadoPedido;
use App\Models\MetodoPago;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Rol;
use App\Models\User;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelProductosCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private CategoriaProducto $categoria;
    private Coleccion $coleccion;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class);

        $this->admin = User::factory()->create();
        $this->admin->roles()->attach(Rol::where('nombre_rol', 'Administrador')->value('id'));

        $this->categoria = CategoriaProducto::firstOrFail();
        $this->coleccion = Coleccion::firstOrFail();
    }

    public function test_crear_producto_exitosamente(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('panel_productos_admin.productos.store'), [
                'sku' => 'PROD-NUEVO-01',
                'nombre' => 'Remera Vintage',
                'descripcion' => 'Algodón 100%',
                'imagen_url' => '/img/productos/remera.jpg',
                'precio' => 15000,
                'precio_oferta' => 12000,
                'stock' => 10,
                'categoria_id' => $this->categoria->id,
                'coleccion_id' => $this->coleccion->id,
                'activo' => '1',
            ]);

        $response->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $producto = Producto::where('sku', 'PROD-NUEVO-01')->firstOrFail();
        $this->assertSame('Remera Vintage', $producto->nombre);
        $this->assertTrue($producto->categorias->contains($this->categoria->id));
        $this->assertSame($this->coleccion->id, $producto->coleccion_id);
    }

    public function test_no_crea_producto_con_sku_duplicado(): void
    {
        Producto::factory()->create(['sku' => 'PROD-EXISTE']);

        $response = $this->actingAs($this->admin)
            ->post(route('panel_productos_admin.productos.store'), [
                'sku' => 'PROD-EXISTE',
                'nombre' => 'Otro nombre',
                'precio' => 10000,
                'categoria_id' => $this->categoria->id,
            ]);

        $response->assertSessionHasErrors('sku');
    }

    public function test_actualizar_producto(): void
    {
        $producto = Producto::factory()->create([
            'sku' => 'ORIG-01',
            'nombre' => 'Nombre Original',
            'precio' => 10000,
        ]);
        $producto->categorias()->attach($this->categoria->id);

        $nuevaCategoria = CategoriaProducto::create(['nombre_categoria' => 'Nueva Cat']);

        $response = $this->actingAs($this->admin)
            ->put(route('panel_productos_admin.productos.update', $producto), [
                'sku' => 'ORIG-01',
                'nombre' => 'Nombre Modificado',
                'precio' => 18000,
                'categoria_id' => $nuevaCategoria->id,
            ]);

        $response->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $producto = $producto->fresh();
        $this->assertSame('Nombre Modificado', $producto->nombre);
        $this->assertSame(18000.0, (float) $producto->precio);
        $this->assertTrue($producto->categorias->contains($nuevaCategoria->id));
        $this->assertFalse($producto->categorias->contains($this->categoria->id));
    }

    public function test_eliminar_producto_sin_pedidos_lo_borra_y_desvincula_categorias(): void
    {
        $producto = Producto::factory()->create();
        $producto->categorias()->attach($this->categoria->id);

        $response = $this->actingAs($this->admin)
            ->delete(route('panel_productos_admin.productos.destroy', $producto));

        $response->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
        $this->assertDatabaseMissing('categoria_producto_producto', [
            'producto_id' => $producto->id,
        ]);
    }

    public function test_eliminar_producto_con_pedidos_no_lo_borra_ni_desvincula_categorias(): void
    {
        $producto = Producto::factory()->create(['stock' => 10]);
        $producto->categorias()->attach($this->categoria->id);

        $direccion = \App\Models\Direccion::factory()->create(['contacto_id' => $this->admin->contacto_id]);

        app(\App\Services\PedidoService::class)->crear(
            $this->admin,
            [['producto_id' => $producto->id, 'cantidad' => 1]],
            $direccion->id,
            MetodoPago::firstOrFail()->id,
        );

        $response = $this->actingAs($this->admin)
            ->delete(route('panel_productos_admin.productos.destroy', $producto));

        $response->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('error');

        // El producto sigue existiendo
        $this->assertDatabaseHas('productos', ['id' => $producto->id]);

        // Y CRUCIAL: sus categorías siguen intactas, no se desasociaron
        $this->assertTrue($producto->fresh()->categorias->contains($this->categoria->id));
    }

    public function test_crud_colecciones(): void
    {
        // Store
        $this->actingAs($this->admin)
            ->post(route('panel_productos_admin.colecciones.store'), ['nombre_coleccion' => 'Invierno 2026'])
            ->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $coleccion = Coleccion::where('nombre_coleccion', 'Invierno 2026')->firstOrFail();

        // Update
        $this->actingAs($this->admin)
            ->put(route('panel_productos_admin.colecciones.update', $coleccion), ['nombre_coleccion' => 'Invierno Exclusivo'])
            ->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $this->assertSame('Invierno Exclusivo', $coleccion->fresh()->nombre_coleccion);

        // Destroy
        $this->actingAs($this->admin)
            ->delete(route('panel_productos_admin.colecciones.destroy', $coleccion))
            ->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('colecciones', ['id' => $coleccion->id]);
    }

    public function test_crud_categorias(): void
    {
        // Store
        $this->actingAs($this->admin)
            ->post(route('panel_productos_admin.categorias.store'), ['nombre_categoria' => 'Camisas'])
            ->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $categoria = CategoriaProducto::where('nombre_categoria', 'Camisas')->firstOrFail();

        // Update
        $this->actingAs($this->admin)
            ->put(route('panel_productos_admin.categorias.update', $categoria), ['nombre_categoria' => 'Camisas y Blusas'])
            ->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $this->assertSame('Camisas y Blusas', $categoria->fresh()->nombre_categoria);

        // Destroy
        $this->actingAs($this->admin)
            ->delete(route('panel_productos_admin.categorias.destroy', $categoria))
            ->assertRedirect(route('panel_productos_admin'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('categorias_producto', ['id' => $categoria->id]);
    }
}
