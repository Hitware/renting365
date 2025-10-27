<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class ClientPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $clientPermissions = [
            ['name' => 'Ver Clientes', 'slug' => 'clients.view', 'module' => 'clients'],
            ['name' => 'Crear Cliente', 'slug' => 'clients.create', 'module' => 'clients'],
            ['name' => 'Editar Cliente', 'slug' => 'clients.edit', 'module' => 'clients'],
            ['name' => 'Eliminar Cliente', 'slug' => 'clients.delete', 'module' => 'clients'],
            ['name' => 'Aprobar Cliente', 'slug' => 'clients.approve', 'module' => 'clients'],
            ['name' => 'Rechazar Cliente', 'slug' => 'clients.reject', 'module' => 'clients'],
            ['name' => 'Ver Datos Financieros', 'slug' => 'clients.view_financial', 'module' => 'clients'],
            ['name' => 'Consultar Midatacrédito', 'slug' => 'clients.query_midatacredito', 'module' => 'clients'],
            ['name' => 'Revisar Documentos', 'slug' => 'clients.review_documents', 'module' => 'clients'],
            ['name' => 'Verificar Referencias', 'slug' => 'clients.verify_references', 'module' => 'clients'],
        ];

        foreach ($clientPermissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }

        // Asignar permisos a roles existentes

        // Admin - todos los permisos
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            $adminPermissions = Permission::where('module', 'clients')->get();
            $adminRole->permissions()->syncWithoutDetaching($adminPermissions);
        }

        // Analista de Crédito - permisos de revisión
        $analistaRole = Role::where('slug', 'analista_credito')->first();
        if ($analistaRole) {
            $analistaPermissions = Permission::whereIn('slug', [
                'clients.view',
                'clients.create',
                'clients.edit',
                'clients.approve',
                'clients.reject',
                'clients.view_financial',
                'clients.query_midatacredito',
                'clients.review_documents',
                'clients.verify_references',
            ])->get();
            $analistaRole->permissions()->syncWithoutDetaching($analistaPermissions);
        }

        // Gerente de Crédito - todos los permisos
        $gerenteRole = Role::where('slug', 'gerente_credito')->first();
        if ($gerenteRole) {
            $gerentePermissions = Permission::where('module', 'clients')->get();
            $gerenteRole->permissions()->syncWithoutDetaching($gerentePermissions);
        }

        // Asesor Comercial - permisos básicos
        $asesorRole = Role::where('slug', 'asesor')->first();
        if ($asesorRole) {
            $asesorPermissions = Permission::whereIn('slug', [
                'clients.view',
                'clients.create',
                'clients.edit',
            ])->get();
            $asesorRole->permissions()->syncWithoutDetaching($asesorPermissions);
        }

        $this->command->info('Permisos del módulo de Clientes creados y asignados exitosamente');
    }
}
