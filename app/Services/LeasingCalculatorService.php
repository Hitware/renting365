<?php

namespace App\Services;

use Carbon\Carbon;

class LeasingCalculatorService
{
    public function calculateMonthlyPayment(float $principal, float $monthlyRate, int $months): float
    {
        if ($monthlyRate == 0) {
            return $principal / $months;
        }

        $rate = $monthlyRate / 100;
        return $principal * ($rate * pow(1 + $rate, $months)) / (pow(1 + $rate, $months) - 1);
    }

    public function generatePaymentSchedule(
        float $principal,
        float $monthlyRate,
        int $months,
        Carbon $startDate,
        int $paymentDay
    ): array {
        $monthlyPayment = $this->calculateMonthlyPayment($principal, $monthlyRate, $months);
        $rate = $monthlyRate / 100;
        $balance = $principal;
        $schedule = [];

        for ($i = 1; $i <= $months; $i++) {
            $interest = $balance * $rate;
            $principalPayment = $monthlyPayment - $interest;
            $balance -= $principalPayment;

            if ($i === $months) {
                $principalPayment += $balance;
                $balance = 0;
            }

            $dueDate = $startDate->copy()->addMonths($i - 1)->day($paymentDay);

            $schedule[] = [
                'payment_number' => $i,
                'due_date' => $dueDate,
                'amount' => round($monthlyPayment, 2),
                'principal' => round($principalPayment, 2),
                'interest' => round($interest, 2),
                'balance' => round(max(0, $balance), 2),
                'status' => 'pendiente'
            ];
        }

        return $schedule;
    }

    public function calculateTotalInterest(float $principal, float $monthlyRate, int $months): float
    {
        $monthlyPayment = $this->calculateMonthlyPayment($principal, $monthlyRate, $months);
        return ($monthlyPayment * $months) - $principal;
    }
}
