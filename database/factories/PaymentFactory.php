<?php

namespace Database\Factories;

use App\Models\LeasingPayment;
use App\Models\LeasingContract;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = LeasingPayment::class;

    public function definition(): array
    {
        $amount = $this->faker->numberBetween(300000, 1000000);

        return [
            'leasing_contract_id' => LeasingContract::factory(),
            'payment_number' => $this->faker->numberBetween(1, 12),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'amount' => $amount,
            'principal' => $amount * 0.8,
            'interest' => $amount * 0.2,
            'balance' => $this->faker->numberBetween(1000000, 5000000),
            'status' => 'pagado',
            'paid_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'amount_paid' => $amount,
            'payment_method' => $this->faker->randomElement(['efectivo', 'transferencia', 'tarjeta']),
            'reference_number' => 'REF-' . $this->faker->unique()->numerify('######'),
        ];
    }
}
