<?php

namespace Tests\Feature;

use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use App\Models\Producto;
use App\Services\CatalogoService;
use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogoServiceTest extends TestCase
{
    use RefreshDatabase;

    private CatalogoService $servicio;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogosSeeder::class); // colecciones y categorías, sin productos
        $this->servicio = app(CatalogoService::class);
    }

    /**
     * Nombres de los productos que devuelve una búsqueda, en el orden en que vienen.
     */
    private function nombres(array $filtros = []): array
    {
        return $this->servicio->buscar($filtros)->pluck('nombre')->all();
    }

    public function test_no_muestra_productos_inactivos(): void
    {
        Producto::factory()->create(['nombre' => 'Visible']);
        Producto::factory()->create(['nombre' => 'Oculto', 'activo' => false]);

        $this->assertSame(['Visible'], $this->nombres());
    }

    public function test_busca_por_nombre_o_sku_sin_traer_inactivos(): void
    {
        Producto::factory()->create(['nombre' => 'Campera negra', 'sku' => 'CAM-001']);
        Producto::factory()->create(['nombre' => 'Buzo gris', 'sku' => 'CAM-002']);
        Producto::factory()->create(['nombre' => 'Campera vieja', 'sku' => 'CAM-003', 'activo' => false]);
        Producto::factory()->create(['nombre' => 'Gorro', 'sku' => 'GOR-001']);

        $this->assertEqualsCanonicalizing(['Campera negra'], $this->nombres(['q' => 'campera']));

        // Busca también por SKU, y el inactivo no aparece aunque coincida
        $this->assertEqualsCanonicalizing(['Campera negra', 'Buzo gris'], $this->nombres(['q' => 'CAM-']));
    }

    public function test_filtra_por_coleccion_y_categoria(): void
    {
        $coleccion = Coleccion::query()->first();
        $categoria = CategoriaProducto::query()->first();

        $deColeccion = Producto::factory()->create(['nombre' => 'De la colección', 'coleccion_id' => $coleccion->id]);
        $deCategoria = Producto::factory()->create(['nombre' => 'De la categoría']);
        $deCategoria->categorias()->attach($categoria->id);
        Producto::factory()->create(['nombre' => 'Sin nada']);

        $this->assertSame(['De la colección'], $this->nombres(['coleccion_id' => $coleccion->id]));
        $this->assertSame(['De la categoría'], $this->nombres(['categoria_id' => $categoria->id]));
    }

    public function test_filtra_en_oferta_y_con_stock(): void
    {
        Producto::factory()->enOferta(8000)->create(['nombre' => 'Oferta con stock']);
        Producto::factory()->enOferta(8000)->create(['nombre' => 'Oferta sin stock', 'stock' => 0]);
        Producto::factory()->create(['nombre' => 'Normal']);

        $this->assertEqualsCanonicalizing(
            ['Oferta con stock', 'Oferta sin stock'],
            $this->nombres(['en_oferta' => true]),
        );

        // Los dos filtros juntos
        $this->assertSame(['Oferta con stock'], $this->nombres(['en_oferta' => true, 'con_stock' => true]));
    }

    public function test_ordena_por_precio_final(): void
    {
        // Precio final: A = 5000 (oferta), B = 7000, C = 9000 (precio normal más bajo que el de A)
        Producto::factory()->enOferta(5000)->create(['nombre' => 'A', 'precio' => 20000]);
        Producto::factory()->create(['nombre' => 'C', 'precio' => 9000]);
        Producto::factory()->create(['nombre' => 'B', 'precio' => 7000]);

        $this->assertSame(['A', 'B', 'C'], $this->nombres(['orden' => 'precio_asc']));
        $this->assertSame(['C', 'B', 'A'], $this->nombres(['orden' => 'precio_desc']));
    }

    public function test_orden_invalido_usa_los_mas_nuevos(): void
    {
        Producto::factory()->create(['nombre' => 'Viejo']);
        Producto::factory()->create(['nombre' => 'Nuevo']);

        $this->assertSame(['Nuevo', 'Viejo'], $this->nombres(['orden' => 'DROP TABLE productos']));
    }

    public function test_pagina_los_resultados(): void
    {
        Producto::factory()->count(15)->create();

        $pagina = $this->servicio->buscar([], 12);

        $this->assertSame(15, $pagina->total());
        $this->assertCount(12, $pagina->items());
        $this->assertSame(2, $pagina->lastPage());
    }

        public function test_la_pagina_de_productos_aplica_los_filtros_de_la_url(): void
    {
        Producto::factory()->enOferta(8000)->create(['nombre' => 'Con oferta']);
        Producto::factory()->create(['nombre' => 'Sin oferta']);

        $this->get('/productos?en_oferta=1&orden=cualquiercosa')
            ->assertOk()
            ->assertViewHas('productos', fn ($productos) => $productos->pluck('nombre')->all() === ['Con oferta']);
    }
}