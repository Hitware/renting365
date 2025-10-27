<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios de prueba
        $admin = User::firstOrCreate(
            ['email' => 'admin@renting365.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $analista = User::firstOrCreate(
            ['email' => 'analista@renting365.com'],
            [
                'name' => 'María López',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $asesor = User::firstOrCreate(
            ['email' => 'asesor@renting365.com'],
            [
                'name' => 'Carlos García',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Asignar roles si existen
        if (class_exists(\App\Models\Role::class)) {
            $adminRole = \App\Models\Role::where('slug', 'admin')->first();
            $analistaRole = \App\Models\Role::where('slug', 'analista_credito')->first();
            $asesorRole = \App\Models\Role::where('slug', 'asesor_comercial')->first();

            if ($adminRole) $admin->roles()->syncWithoutDetaching([$adminRole->id]);
            if ($analistaRole) $analista->roles()->syncWithoutDetaching([$analistaRole->id]);
            if ($asesorRole) $asesor->roles()->syncWithoutDetaching([$asesorRole->id]);
        }

        // Crear clientes de prueba
        $this->createTestClient($asesor->id, $analista->id, 'aprobado', 780);
        $this->createTestClient($asesor->id, $analista->id, 'en_revision', 650);
        $this->createTestClient($asesor->id, null, 'registro_inicial', null);
        $this->createTestClient($asesor->id, $analista->id, 'rechazado', 520);

        $this->command->info('✅ Usuarios y clientes de prueba creados exitosamente');
        $this->command->info('📧 Email: admin@renting365.com | Password: password');
        $this->command->info('📧 Email: analista@renting365.com | Password: password');
        $this->command->info('📧 Email: asesor@renting365.com | Password: password');
    }

    private function createTestClient($createdBy, $analystId, $status, $score)
    {
        $names = [
            ['Juan', 'Andrés', 'Pérez', 'García'],
            ['Ana', 'María', 'Rodríguez', 'López'],
            ['Carlos', 'Alberto', 'Martínez', 'Sánchez'],
            ['Laura', 'Sofía', 'González', 'Ramírez'],
        ];

        $name = $names[array_rand($names)];
        $docNumber = rand(1000000000, 9999999999);

        $client = Client::create([
            'document_type' => 'CC',
            'document_number' => $docNumber,
            'first_name' => $name[0],
            'middle_name' => $name[1],
            'last_name' => $name[2],
            'second_last_name' => $name[3],
            'full_name' => implode(' ', $name),
            'birth_date' => now()->subYears(rand(25, 50)),
            'birth_place' => 'Bogotá',
            'gender' => rand(0, 1) ? 'M' : 'F',
            'marital_status' => ['soltero', 'casado', 'union_libre'][rand(0, 2)],
            'education_level' => ['secundaria', 'tecnico', 'profesional'][rand(0, 2)],
            'dependents_count' => rand(0, 3),
            'status' => $status,
            'assigned_analyst_id' => $analystId,
            'credit_score' => $score,
            'created_by' => $createdBy,
        ]);

        // Contacto
        $client->contacts()->create([
            'contact_type' => 'residencia',
            'address' => 'Calle ' . rand(1, 100) . ' #' . rand(1, 50) . '-' . rand(1, 99),
            'neighborhood' => ['Chapinero', 'Usaquén', 'Suba', 'Engativá'][rand(0, 3)],
            'city' => 'Bogotá',
            'department' => 'Cundinamarca',
            'country' => 'Colombia',
            'phone_mobile' => '+57 3' . rand(10, 99) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
            'email' => strtolower($name[0] . '.' . $name[2]) . '@email.com',
            'is_primary' => true,
        ]);

        // Empleo
        $salary = rand(1500000, 5000000);
        $client->employments()->create([
            'is_current' => true,
            'employment_type' => ['empleado_indefinido', 'empleado_temporal', 'independiente'][rand(0, 2)],
            'employer_name' => ['Empresa ABC', 'Compañía XYZ', 'Corporación 123'][rand(0, 2)],
            'position' => ['Analista', 'Coordinador', 'Gerente', 'Asistente'][rand(0, 3)],
            'monthly_salary' => $salary,
            'total_monthly_income' => $salary,
            'start_date' => now()->subMonths(rand(6, 36)),
        ]);

        // Financiero
        $expenses = $salary * rand(50, 70) / 100;
        $client->financials()->create([
            'month_year' => now()->format('Y-m'),
            'total_income' => $salary,
            'salary_income' => $salary,
            'total_expenses' => $expenses,
            'rent_expense' => $expenses * 0.4,
            'utilities_expense' => $expenses * 0.2,
            'food_expense' => $expenses * 0.3,
            'disposable_income' => $salary - $expenses,
            'debt_to_income_ratio' => $expenses / $salary,
        ]);

        // Referencias
        $client->references()->create([
            'reference_type' => 'personal',
            'full_name' => 'Pedro Ramírez',
            'phone' => '+57 300 123 4567',
            'relationship' => 'Amigo',
            'verification_status' => ['pendiente', 'verificada'][rand(0, 1)],
        ]);

        $client->references()->create([
            'reference_type' => 'familiar',
            'full_name' => 'María Gómez',
            'phone' => '+57 310 987 6543',
            'relationship' => 'Hermana',
            'verification_status' => ['pendiente', 'verificada'][rand(0, 1)],
        ]);

        // Midatacrédito
        if ($score) {
            $client->midatacredito()->create([
                'query_date' => now(),
                'query_type' => 'consulta_completa',
                'score' => $score,
                'risk_level' => $score >= 700 ? 'bajo' : ($score >= 600 ? 'medio' : 'alto'),
                'active_credits_count' => rand(0, 3),
                'total_debt' => rand(0, 10000000),
                'overdue_debt' => $status === 'rechazado' ? rand(100000, 500000) : 0,
                'worst_status' => $status === 'rechazado' ? 'mora_30' : 'al_dia',
                'queried_by' => $analystId,
            ]);
        }

        // Consentimientos
        $client->consents()->create([
            'consent_type' => 'tratamiento_datos',
            'consent_text' => 'Autorizo el tratamiento de mis datos personales',
            'accepted' => true,
            'acceptance_date' => now(),
            'acceptance_ip' => '127.0.0.1',
        ]);
    }
}
