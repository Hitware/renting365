<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class FleetManagerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating Fleet Manager role and permissions...');

        // Create Motorcycles Module Permissions
        $motorcyclePermissions = [
            ['name' => 'Ver Motocicletas', 'slug' => 'motorcycles.view', 'module' => 'motorcycles', 'description' => 'Ver listado de motocicletas'],
            ['name' => 'Crear Motocicleta', 'slug' => 'motorcycles.create', 'module' => 'motorcycles', 'description' => 'Registrar nueva motocicleta'],
            ['name' => 'Editar Motocicleta', 'slug' => 'motorcycles.edit', 'module' => 'motorcycles', 'description' => 'Editar información de motocicleta'],
            ['name' => 'Eliminar Motocicleta', 'slug' => 'motorcycles.delete', 'module' => 'motorcycles', 'description' => 'Eliminar motocicleta'],
            ['name' => 'Ver Historial', 'slug' => 'motorcycles.history', 'module' => 'motorcycles', 'description' => 'Ver historial completo de motocicleta'],

            // Maintenance permissions
            ['name' => 'Gestionar Mantenimientos', 'slug' => 'maintenance.manage', 'module' => 'motorcycles', 'description' => 'Crear y gestionar mantenimientos'],
            ['name' => 'Ver Mantenimientos', 'slug' => 'maintenance.view', 'module' => 'motorcycles', 'description' => 'Ver historial de mantenimientos'],

            // Incidents permissions
            ['name' => 'Gestionar Siniestros', 'slug' => 'incidents.manage', 'module' => 'motorcycles', 'description' => 'Registrar y gestionar siniestros'],
            ['name' => 'Ver Siniestros', 'slug' => 'incidents.view', 'module' => 'motorcycles', 'description' => 'Ver historial de siniestros'],

            // Documents permissions
            ['name' => 'Gestionar Documentos', 'slug' => 'documents.manage', 'module' => 'motorcycles', 'description' => 'Cargar y gestionar documentos'],
            ['name' => 'Ver Documentos', 'slug' => 'documents.view', 'module' => 'motorcycles', 'description' => 'Ver documentos de motocicletas'],
        ];

        $createdPermissions = [];
        foreach ($motorcyclePermissions as $permission) {
            $createdPermissions[] = Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        // Create Fleet Manager Role
        $fleetManagerRole = Role::firstOrCreate(
            ['slug' => 'fleet_manager'],
            [
                'name' => 'Gestor de Flota',
                'description' => 'Administra las motocicletas, mantenimientos, documentos y asignaciones de la flota',
            ]
        );

        // Assign all motorcycle permissions to Fleet Manager
        $permissionIds = collect($createdPermissions)->pluck('id')->toArray();
        $fleetManagerRole->permissions()->sync($permissionIds);

        // Also give them user view and edit own permissions
        $additionalPermissions = Permission::whereIn('slug', [
            'users.view-own',
            'users.edit-own',
        ])->pluck('id')->toArray();

        $fleetManagerRole->permissions()->syncWithoutDetaching($additionalPermissions);

        // Update Admin role to have all new permissions
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminRole->permissions()->syncWithoutDetaching($permissionIds);
        }

        $this->command->info('✅ Fleet Manager role created successfully!');
        $this->command->info('✅ ' . count($motorcyclePermissions) . ' permissions created');
    }
}
