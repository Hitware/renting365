<?php

namespace Database\Factories;

use App\Models\Motorcycle;
use Illuminate\Database\Eloquent\Factories\Factory;

class MotorcycleFactory extends Factory
{
    protected $model = Motorcycle::class;

    public function definition(): array
    {
        $brands = ['AUTECO', 'YAMAHA', 'HONDA', 'SUZUKI', 'KAWASAKI'];
        $brand = $this->faker->randomElement($brands);

        $models = [
            'AUTECO' => ['Victory 100', 'Victory 150', 'Platino 125', 'Discover 125'],
            'YAMAHA' => ['FZ16', 'FZ25', 'MT-03', 'XTZ 125'],
            'HONDA' => ['CB 125F', 'CB 190R', 'XR 190L', 'Wave'],
            'SUZUKI' => ['GN 125', 'AX100', 'GSX-R150'],
            'KAWASAKI' => ['Z125', 'Ninja 300', 'Versys 300'],
        ];

        return [
            'brand' => $brand,
            'model' => $this->faker->randomElement($models[$brand]),
            'year' => $this->faker->numberBetween(2020, 2024),
            'color' => $this->faker->randomElement(['Negro', 'Rojo', 'Azul', 'Blanco', 'Gris']),
            'plate' => strtoupper($this->faker->bothify('???###')),
            'chassis_number' => strtoupper($this->faker->bothify('??############')),
            'engine_number' => strtoupper($this->faker->bothify('??############')),
            'cylinder_capacity' => $this->faker->randomElement(['100', '125', '150', '200', '250']),
            'purchase_price' => $this->faker->numberBetween(3000000, 15000000),
            'sale_price' => $this->faker->numberBetween(4000000, 18000000),
            'status' => 'disponible',
        ];
    }
}
