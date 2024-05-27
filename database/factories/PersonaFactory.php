<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'apellido' => $this->faker->name(),
            'cedula' => $this->faker->numberBetween(1000000, 32000000),
            'correo' => $this->faker->unique()->safeEmail(),
            'telefono' => $this->faker->numberBetween(1000000000, 9999999999),
            'direccion' => $this->faker->name(),
            'estado' => $this->faker->city(),
            'ciudad' => $this->faker->name(),
        ];
    }
}
