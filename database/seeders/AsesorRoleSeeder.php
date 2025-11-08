<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class AsesorRoleSeeder extends Seeder
{
    public function run(): void
    {
        $asesor = Role::where('slug', 'credit_advisor')->first();
        
        if (!$asesor) {
            throw new \Exception('Rol credit_advisor no encontrado');
        }

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
