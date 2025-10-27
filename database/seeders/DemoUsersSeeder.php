<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating demo users...');

        // Get roles
        $adminRole = Role::where('slug', 'admin')->first();
        $advisorRole = Role::where('slug', 'credit_advisor')->first();
        $clientRole = Role::where('slug', 'client')->first();

        if (!$adminRole || !$advisorRole || !$clientRole) {
            $this->command->error('Roles not found! Please run RolesAndPermissionsSeeder first.');
            return;
        }

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@renting365.co'],
            [
                'name' => 'Admin Renting365',
                'email' => 'admin@renting365.co',
                'password' => Hash::make('Admin123!'),
                'phone' => '3001234567',
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        if ($admin->wasRecentlyCreated) {
            // Create profile
            UserProfile::create([
                'user_id' => $admin->id,
                'first_name' => 'Admin',
                'last_name' => 'Renting365',
                'document_type' => 'CC',
                'document_number' => '1000000001',
                'address' => 'Calle 100 #10-20',
                'city' => 'Bogotá',
                'state' => 'Cundinamarca',
                'postal_code' => '110111',
                'birth_date' => '1990-01-01',
            ]);

            // Assign role
            $admin->assignRole($adminRole);

            $this->command->info('✅ Admin user created: admin@renting365.co / Admin123!');
        } else {
            $this->command->warn('⚠️  Admin user already exists');
        }

        // Create Credit Advisor User
        $advisor = User::firstOrCreate(
            ['email' => 'asesor@renting365.co'],
            [
                'name' => 'María González',
                'email' => 'asesor@renting365.co',
                'password' => Hash::make('Asesor123!'),
                'phone' => '3101234567',
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        if ($advisor->wasRecentlyCreated) {
            // Create profile
            UserProfile::create([
                'user_id' => $advisor->id,
                'first_name' => 'María',
                'last_name' => 'González Pérez',
                'document_type' => 'CC',
                'document_number' => '1000000002',
                'address' => 'Carrera 15 #85-40',
                'city' => 'Bogotá',
                'state' => 'Cundinamarca',
                'postal_code' => '110221',
                'birth_date' => '1992-05-15',
            ]);

            // Assign role
            $advisor->assignRole($advisorRole);

            $this->command->info('✅ Credit Advisor user created: asesor@renting365.co / Asesor123!');
        } else {
            $this->command->warn('⚠️  Credit Advisor user already exists');
        }

        // Create Client User
        $client = User::firstOrCreate(
            ['email' => 'cliente@renting365.co'],
            [
                'name' => 'Carlos Ramírez',
                'email' => 'cliente@renting365.co',
                'password' => Hash::make('Cliente123!'),
                'phone' => '3201234567',
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        if ($client->wasRecentlyCreated) {
            // Create profile
            UserProfile::create([
                'user_id' => $client->id,
                'first_name' => 'Carlos',
                'last_name' => 'Ramírez López',
                'document_type' => 'CC',
                'document_number' => '1000000003',
                'address' => 'Avenida 68 #45-30',
                'city' => 'Bogotá',
                'state' => 'Cundinamarca',
                'postal_code' => '110931',
                'birth_date' => '1995-08-20',
            ]);

            // Assign role
            $client->assignRole($clientRole);

            $this->command->info('✅ Client user created: cliente@renting365.co / Cliente123!');
        } else {
            $this->command->warn('⚠️  Client user already exists');
        }

        // Create additional client users for testing
        for ($i = 1; $i <= 3; $i++) {
            $extraClient = User::firstOrCreate(
                ['email' => "cliente{$i}@renting365.co"],
                [
                    'name' => "Cliente Demo {$i}",
                    'email' => "cliente{$i}@renting365.co",
                    'password' => Hash::make('Cliente123!'),
                    'phone' => '320234567' . $i,
                    'is_active' => true,
                    'email_verified_at' => now(),
                    'phone_verified_at' => now(),
                ]
            );

            if ($extraClient->wasRecentlyCreated) {
                UserProfile::create([
                    'user_id' => $extraClient->id,
                    'first_name' => 'Cliente',
                    'last_name' => "Demo {$i}",
                    'document_type' => 'CC',
                    'document_number' => '100000000' . (3 + $i),
                    'address' => "Calle {$i}0 #20-30",
                    'city' => 'Bogotá',
                    'state' => 'Cundinamarca',
                    'postal_code' => '110111',
                    'birth_date' => '1998-01-0' . $i,
                ]);

                $extraClient->assignRole($clientRole);

                $this->command->info("✅ Extra client {$i} created: cliente{$i}@renting365.co / Cliente123!");
            }
        }

        // Create additional advisor for testing
        $advisor2 = User::firstOrCreate(
            ['email' => 'asesor2@renting365.co'],
            [
                'name' => 'Pedro Martínez',
                'email' => 'asesor2@renting365.co',
                'password' => Hash::make('Asesor123!'),
                'phone' => '3151234567',
                'is_active' => true,
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
            ]
        );

        if ($advisor2->wasRecentlyCreated) {
            UserProfile::create([
                'user_id' => $advisor2->id,
                'first_name' => 'Pedro',
                'last_name' => 'Martínez Silva',
                'document_type' => 'CC',
                'document_number' => '1000000010',
                'address' => 'Calle 127 #15-20',
                'city' => 'Bogotá',
                'state' => 'Cundinamarca',
                'postal_code' => '110111',
                'birth_date' => '1988-12-10',
            ]);

            $advisor2->assignRole($advisorRole);

            $this->command->info('✅ Extra advisor created: asesor2@renting365.co / Asesor123!');
        }

        $this->command->info('');
        $this->command->info('🎉 Demo users seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 Login Credentials:');
        $this->command->info('-----------------------------------');
        $this->command->info('🔐 Admin: admin@renting365.co / Admin123!');
        $this->command->info('💼 Asesor 1: asesor@renting365.co / Asesor123!');
        $this->command->info('💼 Asesor 2: asesor2@renting365.co / Asesor123!');
        $this->command->info('👤 Cliente: cliente@renting365.co / Cliente123!');
        $this->command->info('👤 Cliente 1: cliente1@renting365.co / Cliente123!');
        $this->command->info('👤 Cliente 2: cliente2@renting365.co / Cliente123!');
        $this->command->info('👤 Cliente 3: cliente3@renting365.co / Cliente123!');
        $this->command->info('-----------------------------------');
    }
}
