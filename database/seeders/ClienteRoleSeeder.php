<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class ClienteRoleSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(
            ['slug' => 'cliente'],
            [
                'name' => 'Cliente',
                'description' => 'Cliente del sistema con acceso limitado',
            ]
        );

        $permissions = [
            'clients.view.own',
            'contracts.view.own',
            'payments.view.own',
        ];

        foreach ($permissions as $permissionSlug) {
            $permission = Permission::firstOrCreate(
                ['slug' => $permissionSlug],
                [
                    'name' => ucfirst(str_replace('.', ' ', $permissionSlug)),
                    'description' => 'Permission for ' . $permissionSlug,
                    'module' => explode('.', $permissionSlug)[0],
                ]
            );

            if (!$role->permissions()->where('permission_id', $permission->id)->exists()) {
                $role->permissions()->attach($permission->id);
            }
        }

        $this->command->info('Cliente role created successfully!');
    }
}
