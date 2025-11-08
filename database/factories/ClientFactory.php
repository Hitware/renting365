<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'document_type' => 'CC',
            'document_number' => $this->faker->unique()->numerify('##########'),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $firstName . ' ' . $lastName,
            'birth_date' => $this->faker->date('Y-m-d', '-25 years'),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'marital_status' => $this->faker->randomElement(['soltero', 'casado', 'union_libre']),
            'education_level' => $this->faker->randomElement(['primaria', 'secundaria', 'tecnico', 'universitario', 'posgrado']),
            'credit_score' => $this->faker->numberBetween(500, 850),
            'status' => 'aprobado',
        ];
    }
}
