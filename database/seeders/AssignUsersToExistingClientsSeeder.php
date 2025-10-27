<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AssignUsersToExistingClientsSeeder extends Seeder
{
    public function run(): void
    {
        $clientRole = Role::where('slug', 'cliente')->first();
        
        if (!$clientRole) {
            $this->command->error('Role "cliente" not found. Please create it first.');
            return;
        }

        $clientsWithoutUser = Client::whereNull('user_id')->get();
        
        $this->command->info("Found {$clientsWithoutUser->count()} clients without user accounts.");
        
        foreach ($clientsWithoutUser as $client) {
            DB::transaction(function () use ($client, $clientRole) {
                $primaryContact = $client->primaryContact;
                
                if (!$primaryContact || !$primaryContact->email) {
                    $this->command->warn("Client {$client->full_name} (ID: {$client->id}) has no email. Skipping.");
                    return;
                }
                
                $existingUser = User::where('email', $primaryContact->email)->first();
                
                if ($existingUser) {
                    $client->update(['user_id' => $existingUser->id]);
                    $this->command->info("Linked existing user to client: {$client->full_name}");
                } else {
                    $user = User::create([
                        'name' => $client->full_name,
                        'email' => $primaryContact->email,
                        'password' => Hash::make('Cliente2024*'),
                        'phone' => $primaryContact->phone_mobile,
                        'is_active' => true,
                    ]);
                    
                    $user->roles()->attach($clientRole->id);
                    
                    $client->update(['user_id' => $user->id]);
                    
                    $this->command->info("Created user for client: {$client->full_name} - Email: {$primaryContact->email}");
                }
            });
        }
        
        $this->command->info('Process completed successfully!');
    }
}
