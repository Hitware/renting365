<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            // Users Module
            ['name' => 'Ver Usuarios', 'slug' => 'users.view', 'module' => 'users', 'description' => 'Ver lista de usuarios del sistema'],
            ['name' => 'Ver Perfil Propio', 'slug' => 'users.view-own', 'module' => 'users', 'description' => 'Ver su propio perfil de usuario'],
            ['name' => 'Crear Usuarios', 'slug' => 'users.create', 'module' => 'users', 'description' => 'Crear nuevos usuarios en el sistema'],
            ['name' => 'Editar Usuarios', 'slug' => 'users.edit', 'module' => 'users', 'description' => 'Editar información de usuarios'],
            ['name' => 'Editar Perfil Propio', 'slug' => 'users.edit-own', 'module' => 'users', 'description' => 'Editar su propio perfil'],
            ['name' => 'Eliminar Usuarios', 'slug' => 'users.delete', 'module' => 'users', 'description' => 'Eliminar usuarios del sistema'],
            ['name' => 'Restaurar Usuarios', 'slug' => 'users.restore', 'module' => 'users', 'description' => 'Restaurar usuarios eliminados'],
            ['name' => 'Asignar Roles', 'slug' => 'users.assign-roles', 'module' => 'users', 'description' => 'Asignar roles a usuarios'],

            // Roles & Permissions Module
            ['name' => 'Ver Roles', 'slug' => 'roles.view', 'module' => 'roles', 'description' => 'Ver lista de roles'],
            ['name' => 'Crear Roles', 'slug' => 'roles.create', 'module' => 'roles', 'description' => 'Crear nuevos roles'],
            ['name' => 'Editar Roles', 'slug' => 'roles.edit', 'module' => 'roles', 'description' => 'Editar roles existentes'],
            ['name' => 'Eliminar Roles', 'slug' => 'roles.delete', 'module' => 'roles', 'description' => 'Eliminar roles'],
            ['name' => 'Asignar Permisos', 'slug' => 'permissions.assign', 'module' => 'roles', 'description' => 'Asignar permisos a roles'],

            // Activity Logs Module
            ['name' => 'Ver Logs', 'slug' => 'logs.view', 'module' => 'logs', 'description' => 'Ver logs de actividad'],
            ['name' => 'Exportar Logs', 'slug' => 'logs.export', 'module' => 'logs', 'description' => 'Exportar logs de actividad'],

            // Credits Module
            ['name' => 'Ver Solicitudes de Crédito', 'slug' => 'credits.view', 'module' => 'credits', 'description' => 'Ver solicitudes de crédito'],
            ['name' => 'Crear Solicitudes de Crédito', 'slug' => 'credits.create', 'module' => 'credits', 'description' => 'Crear nuevas solicitudes de crédito'],
            ['name' => 'Editar Solicitudes de Crédito', 'slug' => 'credits.edit', 'module' => 'credits', 'description' => 'Editar solicitudes de crédito'],
            ['name' => 'Aprobar Solicitudes de Crédito', 'slug' => 'credits.approve', 'module' => 'credits', 'description' => 'Aprobar o rechazar solicitudes de crédito'],
            ['name' => 'Ver Mis Solicitudes', 'slug' => 'credits.view-own', 'module' => 'credits', 'description' => 'Ver sus propias solicitudes de crédito'],

            // Leasing Contracts Module
            ['name' => 'Ver Mis Contratos', 'slug' => 'contracts.view-own', 'module' => 'contracts', 'description' => 'Ver sus propios contratos de financiación'],
            ['name' => 'Ver Contratos', 'slug' => 'contracts.view', 'module' => 'contracts', 'description' => 'Ver todos los contratos'],
            ['name' => 'Crear Contratos', 'slug' => 'contracts.create', 'module' => 'contracts', 'description' => 'Crear nuevos contratos'],
            ['name' => 'Editar Contratos', 'slug' => 'contracts.edit', 'module' => 'contracts', 'description' => 'Editar contratos'],

            // Payments Module
            ['name' => 'Ver Mis Pagos', 'slug' => 'payments.view-own', 'module' => 'payments', 'description' => 'Ver sus propios pagos y cuotas'],
            ['name' => 'Ver Pagos', 'slug' => 'payments.view', 'module' => 'payments', 'description' => 'Ver todos los pagos'],
            ['name' => 'Registrar Pagos', 'slug' => 'payments.create', 'module' => 'payments', 'description' => 'Registrar pagos de clientes'],

            // Account Statement Module
            ['name' => 'Ver Mi Estado de Cuenta', 'slug' => 'account.view-own', 'module' => 'account', 'description' => 'Ver su propio estado de cuenta'],
            ['name' => 'Ver Estados de Cuenta', 'slug' => 'account.view', 'module' => 'account', 'description' => 'Ver estados de cuenta de clientes'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        // Create Roles
        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrador',
                'description' => 'Tiene acceso completo al sistema y puede gestionar todos los módulos',
            ]
        );

        $creditAdvisorRole = Role::firstOrCreate(
            ['slug' => 'credit_advisor'],
            [
                'name' => 'Asesor de Crédito',
                'description' => 'Puede gestionar solicitudes de crédito y clientes',
            ]
        );

        $clientRole = Role::firstOrCreate(
            ['slug' => 'client'],
            [
                'name' => 'Cliente',
                'description' => 'Usuario final que solicita créditos para adquisición de motocicletas',
            ]
        );

        // Assign all permissions to Admin
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Assign all permissions to Credit Advisor except user management
        $creditAdvisorPermissions = Permission::whereNotIn('slug', [
            'users.create',
            'users.delete',
            'users.restore',
            'users.assign-roles',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.assign',
        ])->pluck('id');
        $creditAdvisorRole->permissions()->sync($creditAdvisorPermissions);

        // Assign specific permissions to Client
        $clientPermissions = Permission::whereIn('slug', [
            'users.view-own',
            'users.edit-own',
            'credits.create',
            'credits.view-own',
            'contracts.view-own',
            'payments.view-own',
            'account.view-own',
        ])->pluck('id');
        $clientRole->permissions()->sync($clientPermissions);

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
