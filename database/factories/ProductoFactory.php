<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => strtoupper(fake()->unique()->bothify('???-###')),
            'nombre' => fake()->words(3, true),
            'descripcion' => fake()->sentence(),
            'imagen_url' => 'img/productos/demo.jpg',
            'activo' => true,
            'precio' => 10000,
            'precio_oferta' => null,
            'stock' => 10,
            'coleccion_id' => null,
        ];
    }

    public function enOferta(float $precioOferta): static
    {
        return $this->state(['precio_oferta' => $precioOferta]);
    }
}
