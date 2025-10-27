<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class AsesorRoleSeeder extends Seeder
{
    public function run(): void
    {
        $asesor = Role::firstOrCreate(
            ['slug' => 'asesor'],
            [
                'name' => 'Asesor',
                'description' => 'Asesor comercial con permisos para gestionar clientes y contratos de leasing'
            ]
        );

        $permissions = Permission::whereIn('slug', [
            'clients.view',
            'clients.create',
            'clients.edit',
            'clients.approve',
            'clients.reject',
            'clients.view_financial',
            'clients.review_documents',
            'clients.verify_references',
            'motorcycles.view',
        ])->get();

        $asesor->permissions()->sync($permissions->pluck('id'));
    }
}
