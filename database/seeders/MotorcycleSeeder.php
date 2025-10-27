<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motorcycle;

class MotorcycleSeeder extends Seeder
{
    public function run(): void
    {
        $motorcycles = [
            [
                'brand' => 'Yamaha',
                'model' => 'FZ-16',
                'year' => 2023,
                'displacement' => 150,
                'plate' => 'ABC123',
                'motor_number' => 'YAMFZ16230001',
                'chassis_number' => 'CHFZ16230001',
                'color' => 'Negro',
                'status' => 'active',
                'purchase_price' => 8500000,
                'purchase_date' => now()->subMonths(2),
                'notes' => 'Moto nueva, ideal para delivery'
            ],
            [
                'brand' => 'Honda',
                'model' => 'CB 125F',
                'year' => 2023,
                'displacement' => 125,
                'plate' => 'DEF456',
                'motor_number' => 'HONCB125230002',
                'chassis_number' => 'CHCB125230002',
                'color' => 'Rojo',
                'status' => 'active',
                'purchase_price' => 7200000,
                'purchase_date' => now()->subMonths(1),
                'notes' => 'Económica y confiable'
            ],
            [
                'brand' => 'Suzuki',
                'model' => 'GN 125',
                'year' => 2023,
                'displacement' => 125,
                'plate' => 'GHI789',
                'motor_number' => 'SUZGN125230003',
                'chassis_number' => 'CHGN125230003',
                'color' => 'Azul',
                'status' => 'active',
                'purchase_price' => 6800000,
                'purchase_date' => now()->subMonths(1),
                'notes' => 'Perfecta para estudiantes'
            ],
            [
                'brand' => 'Yamaha',
                'model' => 'XTZ 125',
                'year' => 2023,
                'displacement' => 125,
                'plate' => 'JKL012',
                'motor_number' => 'YAMXTZ125230004',
                'chassis_number' => 'CHXTZ125230004',
                'color' => 'Blanco',
                'status' => 'active',
                'purchase_price' => 9200000,
                'purchase_date' => now()->subWeeks(3),
                'notes' => 'Enduro, ideal para todo terreno'
            ],
            [
                'brand' => 'Honda',
                'model' => 'Wave 110',
                'year' => 2023,
                'displacement' => 110,
                'plate' => 'MNO345',
                'motor_number' => 'HONWAVE110230005',
                'chassis_number' => 'CHWAVE110230005',
                'color' => 'Gris',
                'status' => 'active',
                'purchase_price' => 5500000,
                'purchase_date' => now()->subWeeks(2),
                'notes' => 'Muy económica en consumo'
            ],
            [
                'brand' => 'Bajaj',
                'model' => 'Pulsar 180',
                'year' => 2023,
                'displacement' => 180,
                'plate' => 'PQR678',
                'motor_number' => 'BAJPUL180230006',
                'chassis_number' => 'CHPUL180230006',
                'color' => 'Negro',
                'status' => 'active',
                'purchase_price' => 10500000,
                'purchase_date' => now()->subWeeks(4),
                'notes' => 'Deportiva, alto rendimiento'
            ],
            [
                'brand' => 'Suzuki',
                'model' => 'Gixxer 150',
                'year' => 2023,
                'displacement' => 150,
                'plate' => 'STU901',
                'motor_number' => 'SUZGIX150230007',
                'chassis_number' => 'CHGIX150230007',
                'color' => 'Azul',
                'status' => 'active',
                'purchase_price' => 9800000,
                'purchase_date' => now()->subWeeks(3),
                'notes' => 'Estilo deportivo'
            ],
            [
                'brand' => 'Yamaha',
                'model' => 'MT-03',
                'year' => 2023,
                'displacement' => 321,
                'plate' => 'VWX234',
                'motor_number' => 'YAMMT03230008',
                'chassis_number' => 'CHMT03230008',
                'color' => 'Gris',
                'status' => 'active',
                'purchase_price' => 18500000,
                'purchase_date' => now()->subMonths(2),
                'notes' => 'Naked deportiva'
            ],
            [
                'brand' => 'Honda',
                'model' => 'XR 190',
                'year' => 2023,
                'displacement' => 190,
                'plate' => 'YZA567',
                'motor_number' => 'HONXR190230009',
                'chassis_number' => 'CHXR190230009',
                'color' => 'Rojo',
                'status' => 'active',
                'purchase_price' => 11200000,
                'purchase_date' => now()->subWeeks(5),
                'notes' => 'Doble propósito'
            ],
            [
                'brand' => 'Kawasaki',
                'model' => 'Ninja 400',
                'year' => 2023,
                'displacement' => 399,
                'plate' => 'BCD890',
                'motor_number' => 'KAWNIN400230010',
                'chassis_number' => 'CHNIN400230010',
                'color' => 'Verde',
                'status' => 'active',
                'purchase_price' => 24500000,
                'purchase_date' => now()->subMonths(3),
                'notes' => 'Deportiva de alta gama'
            ]
        ];

        foreach ($motorcycles as $motorcycle) {
            Motorcycle::create($motorcycle);
        }
    }
}
