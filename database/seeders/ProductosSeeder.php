<?php

namespace Database\Seeders;

use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use Illuminate\Database\Seeder;

class ProductosSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            [
                'sku' => 'REM-001',
                'nombre' => 'Remera Oversize AURA - Overflow',
                'descripcion' => 'Remera oversize de algodón.',
                'precio' => 28900,
                'precio_oferta' => 23100,
                'stock' => 25,
                'coleccion' => 'Otoño 2026',
                'categoria' => 'Remeras',
            ],
            [
                'sku' => 'PAN-001',
                'nombre' => 'Pantalón Baggy AURA - Class Division',
                'descripcion' => 'Pantalón baggy de corte amplio.',
                'precio' => 42000,
                'precio_oferta' => 35700,
                'stock' => 15,
                'coleccion' => 'Otoño 2026',
                'categoria' => 'Pantalones',
            ],
            [
                'sku' => 'HW-001',
                'nombre' => 'Gorro de lana Y2K - Century War',
                'descripcion' => 'Gorro de lana de estilo Y2K.',
                'precio' => 61500,
                'precio_oferta' => 43050,
                'stock' => 10,
                'coleccion' => 'Invierno 2025',
                'categoria' => 'HeadWear',
            ],
            [
                'sku' => 'REM-002',
                'nombre' => 'Remera Oversize TripleZ - Colorful',
                'descripcion' => 'Remera oversize estampada.',
                'precio' => 19800,
                'precio_oferta' => 17820,
                'stock' => 30,
                'coleccion' => 'Básicos',
                'categoria' => 'Remeras',
            ],
        ];

        foreach ($productos as $dato) {
            $coleccion = Coleccion::where('nombre_coleccion', $dato['coleccion'])->first();
            $categoria = CategoriaProducto::where('nombre_categoria', $dato['categoria'])->first();

            $producto = $coleccion->productos()->create([
                'sku' => $dato['sku'],
                'nombre' => $dato['nombre'],
                'descripcion' => $dato['descripcion'],
                'precio' => $dato['precio'],
                'precio_oferta' => $dato['precio_oferta'],
                'stock' => $dato['stock'],
                'imagen_url' => '/img/productos/' . strtolower($dato['sku']) . '.jpg',
            ]);

            $producto->categorias()->attach($categoria->id);
        }
    }
}