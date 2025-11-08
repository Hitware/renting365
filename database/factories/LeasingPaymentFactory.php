<?php

namespace Database\Factories;

use App\Models\LeasingPayment;
use App\Models\LeasingContract;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeasingPaymentFactory extends Factory
{
    protected $model = LeasingPayment::class;

    public function definition(): array
    {
        return [
            'leasing_contract_id' => LeasingContract::factory(),
            'payment_number' => $this->faker->numberBetween(1, 12),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'amount' => 500000,
            'principal' => 416667,
            'interest' => 83333,
            'balance' => $this->faker->numberBetween(1000000, 5000000),
            'status' => 'pendiente',
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pagado',
            'paid_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'amount_paid' => $attributes['amount'],
            'payment_method' => $this->faker->randomElement(['efectivo', 'transferencia', 'tarjeta']),
            'reference_number' => 'REF-' . $this->faker->unique()->numerify('######'),
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'atrasado',
            'due_date' => $this->faker->dateTimeBetween('-1 month', '-1 day'),
        ]);
    }
}
