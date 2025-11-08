<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Client;
use App\Models\Motorcycle;
use App\Models\LeasingContract;
use App\Models\LeasingPayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClientAccountControllerTest extends TestCase
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
                'status' => $i <= 3 ? 'pagado' : 'pendiente',
            ]);
        }
    }

    /** @test */
    public function client_can_view_their_own_account_statement()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('client.account'));

        $response->assertStatus(200);
        $response->assertViewIs('client.account-statement-page');
        $response->assertViewHas('clientId', $this->client->id);
    }

    /** @test */
    public function client_without_client_profile_cannot_access_account_statement()
    {
        $regularUser = User::factory()->create();

        $response = $this->actingAs($regularUser)
            ->get(route('client.account'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_specific_client_account_statement()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('client.account.show', $this->client));

        $response->assertStatus(200);
        $response->assertViewIs('client.account-statement-page');
        $response->assertViewHas('clientId', $this->client->id);
    }

    /** @test */
    public function admin_without_permission_cannot_view_client_account()
    {
        $userWithoutPermission = User::factory()->create();

        $response = $this->actingAs($userWithoutPermission)
            ->get(route('client.account.show', $this->client));

        $response->assertStatus(403);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_account_statement()
    {
        $response = $this->get(route('client.account'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('client.account.show', $this->client));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function client_cannot_view_other_clients_account_statement()
    {
        // Create another client
        $otherClient = Client::factory()->create();

        $response = $this->actingAs($this->clientUser)
            ->get(route('client.account.show', $otherClient));

        $response->assertStatus(403);
    }

    /** @test */
    public function account_statement_page_loads_livewire_component()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('client.account'));

        $response->assertStatus(200);
        $response->assertSeeLivewire('client.account-statement');
    }
}
