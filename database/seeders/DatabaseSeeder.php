<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        $this->command->info('');

        // Seed roles and permissions first
        $this->call(RolesAndPermissionsSeeder::class);

        // Seed client permissions
        $this->call(ClientPermissionsSeeder::class);

        // Seed Fleet Manager role and permissions
        $this->call(FleetManagerRoleSeeder::class);

        // Then seed demo users
        $this->call(DemoUsersSeeder::class);

        // Seed test data (users and clients)
        $this->call(TestDataSeeder::class);

        $this->command->info('');
        $this->command->info('✨ Database seeding completed successfully!');
    }
}
