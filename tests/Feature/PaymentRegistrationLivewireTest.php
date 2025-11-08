<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Motorcycle;
use App\Models\LeasingContract;
use App\Models\LeasingPayment;
use App\Livewire\Payments\PaymentRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PaymentRegistrationLivewireTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $adminUser;
    protected $client;
    protected $contract;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles and permissions
        $adminRole = Role::create(['name' => 'admin']);
        Permission::create(['name' => 'clients.view']);
        Permission::create(['name' => 'clients.create']);
        $adminRole->givePermissionTo(['clients.view', 'clients.create']);

        // Create admin user
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');

        // Create client
        $this->client = Client::factory()->create();

        // Create motorcycle
        $motorcycle = Motorcycle::factory()->create();

        // Create contract
        $this->contract = LeasingContract::create([
            'client_id' => $this->client->id,
            'motorcycle_id' => $motorcycle->id,
            'contract_number' => 'CONT-' . now()->format('Ymd') . '-001',
            'start_date' => now(),
            'end_date' => now()->addMonths(12),
            'monthly_payment' => 500000,
            'total_amount' => 6000000,
            'down_payment' => 1000000,
            'financed_amount' => 5000000,
            'interest_rate' => 2.5,
            'term_months' => 12,
            'status' => 'activo',
        ]);

        // Create payments
        for ($i = 1; $i <= 12; $i++) {
            LeasingPayment::create([
                'leasing_contract_id' => $this->contract->id,
                'payment_number' => $i,
                'due_date' => now()->addMonths($i - 1),
                'amount' => 500000,
                'principal' => 416667,
                'interest' => 83333,
                'balance' => 5000000 - ($i * 416667),
                'status' => 'pendiente',
            ]);
        }
    }

    /** @test */
    public function component_renders_successfully()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->assertStatus(200);
    }

    /** @test */
    public function can_search_contracts_by_client_name()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->set('search', $this->client->full_name)
            ->assertSet('contracts', function ($contracts) {
                return $contracts->count() > 0;
            });
    }

    /** @test */
    public function can_search_contracts_by_document_number()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->set('search', $this->client->document_number)
            ->assertSet('contracts', function ($contracts) {
                return $contracts->count() > 0;
            });
    }

    /** @test */
    public function can_select_contract()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->call('selectContract', $this->contract->id)
            ->assertSet('selectedContract', function ($contract) {
                return $contract !== null;
            })
            ->assertSet('showModal', true);
    }

    /** @test */
    public function can_register_payment_successfully()
    {
        $payment = $this->contract->payments()->first();

        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->call('selectContract', $this->contract->id)
            ->set('payment_date', now()->format('Y-m-d'))
            ->set('amount_received', 500000)
            ->set('payment_method', 'efectivo')
            ->set('reference_number', 'REF-001')
            ->set('notes', 'Pago puntual')
            ->call('registerPayment')
            ->assertSet('showSuccess', true);

        // Verify payment was updated in database
        $this->assertDatabaseHas('leasing_payments', [
            'id' => $payment->id,
            'status' => 'pagado',
            'amount_paid' => 500000,
            'payment_method' => 'efectivo',
            'reference_number' => 'REF-001',
            'notes' => 'Pago puntual',
        ]);
    }

    /** @test */
    public function payment_registration_requires_all_fields()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->call('selectContract', $this->contract->id)
            ->set('payment_date', '')
            ->set('amount_received', '')
            ->set('payment_method', '')
            ->call('registerPayment')
            ->assertHasErrors(['payment_date', 'amount_received', 'payment_method']);
    }

    /** @test */
    public function amount_received_must_be_positive()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->call('selectContract', $this->contract->id)
            ->set('payment_date', now()->format('Y-m-d'))
            ->set('amount_received', -100)
            ->set('payment_method', 'efectivo')
            ->call('registerPayment')
            ->assertHasErrors(['amount_received']);
    }

    /** @test */
    public function payment_method_must_be_valid()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->call('selectContract', $this->contract->id)
            ->set('payment_date', now()->format('Y-m-d'))
            ->set('amount_received', 500000)
            ->set('payment_method', 'invalid_method')
            ->call('registerPayment')
            ->assertHasErrors(['payment_method']);
    }

    /** @test */
    public function contract_status_updates_when_all_payments_completed()
    {
        // Mark all payments as paid except the last one
        $this->contract->payments()->limit(11)->update(['status' => 'pagado']);

        $lastPayment = $this->contract->payments()->orderBy('payment_number', 'desc')->first();

        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->call('selectContract', $this->contract->id)
            ->set('payment_date', now()->format('Y-m-d'))
            ->set('amount_received', 500000)
            ->set('payment_method', 'efectivo')
            ->call('registerPayment');

        // Verify contract status is updated
        $this->assertDatabaseHas('leasing_contracts', [
            'id' => $this->contract->id,
            'status' => 'completado',
        ]);
    }

    /** @test */
    public function modal_closes_after_successful_payment()
    {
        Livewire::actingAs($this->adminUser)
            ->test(PaymentRegistration::class)
            ->call('selectContract', $this->contract->id)
            ->set('payment_date', now()->format('Y-m-d'))
            ->set('amount_received', 500000)
            ->set('payment_method', 'efectivo')
            ->call('registerPayment')
            ->call('closeModal')
            ->assertSet('showModal', false)
            ->assertSet('showSuccess', false);
    }
}
