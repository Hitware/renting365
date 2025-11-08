<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Motorcycle;
use App\Models\LeasingContract;
use App\Models\LeasingPayment;
use App\Livewire\Client\AccountStatement;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AccountStatementLivewireTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $adminUser;
    protected $clientUser;
    protected $client;
    protected $contract;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles and permissions
        $adminRole = Role::create(['name' => 'admin']);
        Permission::create(['name' => 'clients.view']);
        $adminRole->givePermissionTo('clients.view');

        // Create admin user
        $this->adminUser = User::factory()->create();
        $this->adminUser->assignRole('admin');

        // Create client and user
        $this->client = Client::factory()->create();
        $this->clientUser = User::factory()->create();
        $this->clientUser->client()->associate($this->client);
        $this->clientUser->save();

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
                'status' => $i <= 3 ? 'pagado' : ($i == 4 ? 'atrasado' : 'pendiente'),
                'paid_at' => $i <= 3 ? now()->subMonths(13 - $i) : null,
                'amount_paid' => $i <= 3 ? 500000 : null,
                'payment_method' => $i <= 3 ? 'efectivo' : null,
            ]);
        }
    }

    /** @test */
    public function component_renders_successfully_for_client()
    {
        Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class)
            ->assertStatus(200);
    }

    /** @test */
    public function component_renders_successfully_for_admin_viewing_client()
    {
        Livewire::actingAs($this->adminUser)
            ->test(AccountStatement::class, ['clientId' => $this->client->id])
            ->assertStatus(200);
    }

    /** @test */
    public function component_loads_client_contracts()
    {
        Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class)
            ->assertSet('client', function ($client) {
                return $client->id === $this->client->id;
            })
            ->assertSet('contracts', function ($contracts) {
                return $contracts->count() > 0;
            });
    }

    /** @test */
    public function component_selects_first_contract_by_default()
    {
        Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class)
            ->assertSet('selectedContract', $this->contract->id);
    }

    /** @test */
    public function can_switch_between_contracts()
    {
        // Create another contract
        $motorcycle2 = Motorcycle::factory()->create();
        $contract2 = LeasingContract::create([
            'client_id' => $this->client->id,
            'motorcycle_id' => $motorcycle2->id,
            'contract_number' => 'CONT-' . now()->format('Ymd') . '-002',
            'start_date' => now(),
            'end_date' => now()->addMonths(24),
            'monthly_payment' => 700000,
            'total_amount' => 16800000,
            'down_payment' => 2000000,
            'financed_amount' => 14800000,
            'interest_rate' => 2.5,
            'term_months' => 24,
            'status' => 'activo',
        ]);

        Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class)
            ->call('selectContract', $contract2->id)
            ->assertSet('selectedContract', $contract2->id);
    }

    /** @test */
    public function displays_correct_payment_statistics()
    {
        $component = Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class);

        $selectedContractData = $component->get('selectedContractData');

        // Verify statistics
        $this->assertEquals(3, $selectedContractData['total_paid']); // 3 paid payments
        $this->assertEquals(9, $selectedContractData['total_pending']); // 8 pendiente + 1 atrasado
        $this->assertEquals(4500000, $selectedContractData['pending_balance']); // 9 x 500000
    }

    /** @test */
    public function displays_next_payment_correctly()
    {
        $component = Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class);

        $selectedContractData = $component->get('selectedContractData');

        // Verify next payment is the overdue one (payment #4)
        $this->assertNotNull($selectedContractData['next_payment']);
        $this->assertEquals(4, $selectedContractData['next_payment']->payment_number);
        $this->assertEquals('atrasado', $selectedContractData['next_payment']->status);
    }

    /** @test */
    public function displays_correct_status_labels()
    {
        $component = Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class);

        $selectedContractData = $component->get('selectedContractData');

        // Verify status label for active contract
        $this->assertEquals('Al Día', $selectedContractData['status_label']);
    }

    /** @test */
    public function displays_all_payments_in_chronological_order()
    {
        $component = Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class);

        $selectedContractData = $component->get('selectedContractData');
        $payments = $selectedContractData['payments'];

        $this->assertCount(12, $payments);

        // Verify chronological order
        for ($i = 0; $i < count($payments) - 1; $i++) {
            $this->assertLessThanOrEqual(
                $payments[$i + 1]->payment_number,
                $payments[$i]->payment_number
            );
        }
    }

    /** @test */
    public function user_without_client_profile_gets_error()
    {
        $regularUser = User::factory()->create();

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);

        Livewire::actingAs($regularUser)
            ->test(AccountStatement::class);
    }

    /** @test */
    public function displays_contract_details_correctly()
    {
        $component = Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class);

        $selectedContractData = $component->get('selectedContractData');

        $this->assertEquals($this->contract->contract_number, $selectedContractData['contract_number']);
        $this->assertEquals($this->contract->monthly_payment, $selectedContractData['monthly_payment']);
        $this->assertEquals($this->contract->term_months, $selectedContractData['term_months']);
    }

    /** @test */
    public function only_shows_active_mora_and_completed_contracts()
    {
        // Create a cancelled contract
        $motorcycle = Motorcycle::factory()->create();
        LeasingContract::create([
            'client_id' => $this->client->id,
            'motorcycle_id' => $motorcycle->id,
            'contract_number' => 'CONT-CANCELLED',
            'start_date' => now(),
            'end_date' => now()->addMonths(12),
            'monthly_payment' => 500000,
            'total_amount' => 6000000,
            'down_payment' => 1000000,
            'financed_amount' => 5000000,
            'interest_rate' => 2.5,
            'term_months' => 12,
            'status' => 'cancelado',
        ]);

        $component = Livewire::actingAs($this->clientUser)
            ->test(AccountStatement::class);

        $contracts = $component->get('contracts');

        // Should only have 1 contract (not the cancelled one)
        $this->assertCount(1, $contracts);
    }
}
