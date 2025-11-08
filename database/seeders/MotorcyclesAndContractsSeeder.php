<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Motorcycle;
use App\Models\LeasingContract;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MotorcyclesAndContractsSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🏍️ Creating motorcycles and contracts...');

        // Crear motos
        $motorcycles = [
            [
                'brand' => 'AUTECO',
                'model' => 'TVS Sport 100',
                'year' => 2024,
                'displacement' => 100,
                'plate' => 'ABC123',
                'motor_number' => 'ENG123456',
                'chassis_number' => 'CHS123456',
                'color' => 'Rojo',
                'purchase_price' => 6500000,
                'purchase_date' => Carbon::now()->subMonths(2),
                'status' => 'sold',
                'created_by' => 1,
            ],
            [
                'brand' => 'AUTECO',
                'model' => 'TVS Sport 100',
                'year' => 2024,
                'displacement' => 100,
                'plate' => 'DEF456',
                'motor_number' => 'ENG456789',
                'chassis_number' => 'CHS456789',
                'color' => 'Negro',
                'purchase_price' => 6500000,
                'purchase_date' => Carbon::now()->subMonths(1),
                'status' => 'sold',
                'created_by' => 1,
            ],
            [
                'brand' => 'AUTECO',
                'model' => 'TVS Sport 100',
                'year' => 2024,
                'displacement' => 100,
                'plate' => 'GHI789',
                'motor_number' => 'ENG789012',
                'chassis_number' => 'CHS789012',
                'color' => 'Azul',
                'purchase_price' => 6500000,
                'purchase_date' => Carbon::now()->subDays(15),
                'status' => 'sold',
                'created_by' => 1,
            ],
        ];

        foreach ($motorcycles as $motoData) {
            Motorcycle::firstOrCreate(
                ['plate' => $motoData['plate']],
                $motoData
            );
        }

        $this->command->info('✅ 3 motorcycles created');

        // Obtener clientes aprobados
        $clients = Client::where('status', 'aprobado')->take(3)->get();

        if ($clients->count() < 3) {
            $this->command->warn('⚠️ Not enough approved clients. Creating contracts with available clients.');
        }

        // Crear contratos solo para motos sin contrato
        $motos = Motorcycle::where('status', 'sold')
            ->whereDoesntHave('leasingContracts')
            ->latest()
            ->take(3)
            ->get();
        
        if ($motos->isEmpty()) {
            $this->command->info('ℹ️ All motorcycles already have contracts');
            return;
        }
        
        foreach ($motos as $index => $moto) {
            $client = $clients[$index] ?? $clients->first();
            
            if (!$client) {
                $this->command->error('❌ No clients available for contracts');
                return;
            }

            $startDate = Carbon::now()->subMonths(2 - $index);
            $termMonths = 12;
            $monthlyPayment = 350000;
            $initialPayment = 650000;
            $financedAmount = $moto->purchase_price - $initialPayment;

            $contract = LeasingContract::create([
                'contract_number' => 'LC-' . now()->format('YmdHis') . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'client_id' => $client->id,
                'motorcycle_id' => $moto->id,
                'motorcycle_value' => $moto->purchase_price,
                'initial_payment' => $initialPayment,
                'financed_amount' => $financedAmount,
                'term_months' => $termMonths,
                'monthly_rate' => 0,
                'monthly_payment' => $monthlyPayment,
                'payment_day' => 5,
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addMonths($termMonths),
                'status' => 'activo',
                'contract_signed_at' => $startDate,
                'created_by' => 1,
                'approved_by' => 1,
                'approved_at' => $startDate,
            ]);

            // Crear cuotas
            $balance = $financedAmount;
            $totalPayments = $monthlyPayment * $termMonths;
            $totalInterest = $totalPayments - $financedAmount;
            $interestPerPayment = $totalInterest / $termMonths;
            $principalPerPayment = $monthlyPayment - $interestPerPayment;

            for ($i = 1; $i <= $termMonths; $i++) {
                $dueDate = $startDate->copy()->addMonths($i - 1)->day(5);
                $principal = ($i == $termMonths) ? $balance : $principalPerPayment;
                $interest = $monthlyPayment - $principal;
                $balance -= $principal;

                // Determinar estado según la fecha
                $status = 'pendiente';
                $paidAt = null;
                $paidAmount = 0;

                if ($dueDate->isPast()) {
                    // Pagos vencidos hace más de 5 días
                    if ($dueDate->diffInDays(now()) > 5) {
                        $status = 'vencido';
                    } else {
                        // Algunos pagados, otros pendientes
                        if ($i <= 2) {
                            $status = 'pagado';
                            $paidAt = $dueDate->copy()->addDays(rand(1, 3));
                            $paidAmount = $monthlyPayment;
                        }
                    }
                }

                $contract->payments()->create([
                    'payment_number' => $i,
                    'due_date' => $dueDate,
                    'amount' => $monthlyPayment,
                    'principal' => $principal,
                    'interest' => $interest,
                    'balance' => max(0, $balance),
                    'status' => $status,
                    'paid_at' => $paidAt,
                    'paid_amount' => $paidAmount,
                ]);
            }

            $this->command->info("✅ Contract {$contract->contract_number} created with {$termMonths} payments");
        }

        $this->command->info('🎉 Motorcycles and contracts seeded successfully!');
    }
}
