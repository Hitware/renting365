<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class ClientUsersSeeder extends Seeder
{
    public function run(): void
    {
        $clientRole = Role::where('name', 'cliente')->first();
        
        // Obtener clientes con contratos activos
        $clients = Client::whereHas('leasingContracts', function($query) {
            $query->where('status', 'activo');
        })->get();

        foreach ($clients as $client) {
            // Verificar si ya tiene usuario
            if (!$client->user_id) {
                $user = User::create([
                    'name' => $client->full_name,
                    'email' => strtolower(str_replace(' ', '', $client->full_name)) . '@cliente.com',
                    'password' => Hash::make('Cliente123!'),
                    'email_verified_at' => now(),
                ]);

                $user->assignRole($clientRole);
                
                $client->update(['user_id' => $user->id]);
            }
        }
    }
}
