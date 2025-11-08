<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Client;
use App\Models\Role;
use App\Models\Permission;

class ClientPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    /** @test */
    public function cliente_tiene_permiso_ver_propios_contratos()
    {
        $user = User::factory()->create();
        $user->assignRole('client');
        
        $this->assertTrue($user->hasPermission('contracts.view-own'));
    }

    /** @test */
    public function cliente_tiene_permiso_ver_propios_pagos()
    {
        $user = User::factory()->create();
        $user->assignRole('client');
        
        $this->assertTrue($user->hasPermission('payments.view-own'));
    }

    /** @test */
    public function cliente_tiene_permiso_ver_propia_cuenta()
    {
        $user = User::factory()->create();
        $user->assignRole('client');
        
        $this->assertTrue($user->hasPermission('account.view-own'));
    }

    /** @test */
    public function cliente_no_tiene_permiso_crear_contratos()
    {
        $user = User::factory()->create();
        $user->assignRole('client');
        
        $this->assertFalse($user->hasPermission('contracts.create'));
    }

    /** @test */
    public function cliente_no_tiene_permiso_editar_contratos()
    {
        $user = User::factory()->create();
        $user->assignRole('client');
        
        $this->assertFalse($user->hasPermission('contracts.edit'));
    }

    /** @test */
    public function cliente_no_tiene_permiso_eliminar_contratos()
    {
        $user = User::factory()->create();
        $user->assignRole('client');
        
        $this->assertFalse($user->hasPermission('contracts.delete'));
    }

    /** @test */
    public function admin_tiene_todos_los_permisos()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        
        $this->assertTrue($user->hasPermission('contracts.view'));
        $this->assertTrue($user->hasPermission('contracts.create'));
        $this->assertTrue($user->hasPermission('contracts.edit'));
        $this->assertTrue($user->hasPermission('payments.view'));
        $this->assertTrue($user->hasPermission('payments.create'));
        $this->assertTrue($user->hasPermission('users.view'));
    }

    /** @test */
    public function usuario_sin_rol_no_tiene_permisos()
    {
        $user = User::factory()->create();
        
        $this->assertFalse($user->hasPermission('contracts.view-own'));
        $this->assertFalse($user->hasPermission('payments.view-own'));
        $this->assertFalse($user->hasPermission('account.view-own'));
    }
}
