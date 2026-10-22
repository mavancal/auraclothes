<?php

namespace Database\Factories;

use App\Models\Direccion;
use App\Models\Contacto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Direccion>
 */
class DireccionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'calle' => fake()->streetName(),
            'numero' => (string) fake()->numberBetween(1, 5000),
            'cod_postal' => '3300',
            'es_principal' => true,
            'localidad_id' => 1,
            'contacto_id' => Contacto::factory(),
        ];
    }
}
