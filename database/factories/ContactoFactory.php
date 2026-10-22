<?php

namespace Database\Factories;

use App\Models\Contacto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contacto>
 */
class ContactoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellido' => fake()->lastName(),
            'tipo_documento_id' => 1,
            'numero_documento' => (string) fake()->unique()->numberBetween(20000000, 49999999),
            'fecha_nacimiento' => fake()->date('Y-m-d', '-18 years'),
            'telefono' => fake()->numerify('376#######'),
            'email_contacto' => fake()->unique()->safeEmail(),
            'tipo_persona_id' => 1,
        ];
    }
}
