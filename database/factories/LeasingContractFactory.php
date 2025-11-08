<?php

namespace Database\Factories;

use App\Models\LeasingContract;
use App\Models\Client;
use App\Models\Motorcycle;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeasingContractFactory extends Factory
{
    protected $model = LeasingContract::class;

    public function definition(): array
    {
        $motorcycleValue = $this->faker->numberBetween(5000000, 15000000);
        $initialPayment = $motorcycleValue * 0.2;
        $financedAmount = $motorcycleValue - $initialPayment;
        $termMonths = $this->faker->randomElement([12, 18, 24, 36]);
        $interestRate = $this->faker->randomFloat(2, 1.5, 3.5);
        $monthlyPayment = $financedAmount / $termMonths;

        return [
            'contract_number' => 'CTR-' . $this->faker->unique()->numerify('######'),
            'client_id' => Client::factory(),
            'motorcycle_id' => Motorcycle::factory(),
            'contract_date' => now(),
            'start_date' => now(),
            'end_date' => now()->addMonths($termMonths),
            'motorcycle_value' => $motorcycleValue,
            'initial_payment' => $initialPayment,
            'financed_amount' => $financedAmount,
            'term_months' => $termMonths,
            'monthly_payment' => $monthlyPayment,
            'interest_rate' => $interestRate,
            'payment_day' => $this->faker->numberBetween(1, 28),
            'payment_frequency' => 'mensual',
            'status' => 'active',
        ];
    }
}
