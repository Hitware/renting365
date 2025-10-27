<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use App\Livewire\Clients\ClientForm;

class ClientCreationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    public function test_client_form_renders()
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $this->actingAs($user);

        Livewire::test(ClientForm::class)
            ->assertStatus(200)
            ->assertSee('Registro de Nuevo Cliente');
    }

    public function test_can_navigate_through_steps()
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $this->actingAs($user);

        Livewire::test(ClientForm::class)
            ->assertSet('currentStep', 1)
            ->set('document_type', 'CC')
            ->set('document_number', '1234567890')
            ->set('first_name', 'Juan')
            ->set('last_name', 'Perez')
            ->set('birth_date', '1990-01-15')
            ->set('gender', 'M')
            ->set('marital_status', 'soltero')
            ->set('education_level', 'profesional')
            ->call('nextStep')
            ->assertSet('currentStep', 2);
    }

    public function test_can_create_client()
    {
        $user = User::factory()->create();
        $user->roles()->attach(1);

        $this->actingAs($user);

        Livewire::test(ClientForm::class)
            ->set('document_type', 'CC')
            ->set('document_number', '1234567890')
            ->set('first_name', 'Juan')
            ->set('last_name', 'Perez')
            ->set('birth_date', '1990-01-15')
            ->set('gender', 'M')
            ->set('marital_status', 'soltero')
            ->set('education_level', 'profesional')
            ->call('nextStep')
            ->set('address', 'Calle 123')
            ->set('city', 'Bogota')
            ->set('department', 'Cundinamarca')
            ->set('phone_mobile', '3001234567')
            ->set('email', 'test@test.com')
            ->call('nextStep')
            ->set('employment_type', 'empleado_indefinido')
            ->set('employer_name', 'Empresa Test')
            ->set('position', 'Desarrollador')
            ->set('monthly_salary', 5000000)
            ->set('start_date', '2020-01-01')
            ->call('nextStep')
            ->set('total_income', 5000000)
            ->set('total_expenses', 3000000)
            ->call('nextStep')
            ->set('references.0.name', 'Referencia 1')
            ->set('references.0.phone', '3001111111')
            ->set('references.1.name', 'Referencia 2')
            ->set('references.1.phone', '3002222222')
            ->set('references.2.name', 'Referencia 3')
            ->set('references.2.phone', '3003333333')
            ->call('nextStep')
            ->set('consent_data_treatment', true)
            ->set('consent_credit_query', true)
            ->call('submit');

        $this->assertDatabaseHas('clients', [
            'document_number' => '1234567890',
            'first_name' => 'Juan',
            'last_name' => 'Perez'
        ]);
    }
}
