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

class DashboardControllerTest extends TestCase
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
            ]);
        }
    }

    /** @test */
    public function admin_sees_admin_dashboard()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard');
    }

    /** @test */
    public function client_sees_client_dashboard()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboards.client');
    }

    /** @test */
    public function client_dashboard_displays_correct_data()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('client');
        $response->assertViewHas('contracts');
        $response->assertViewHas('totalContracts');
        $response->assertViewHas('activeContracts');
        $response->assertViewHas('totalPaid');
        $response->assertViewHas('totalPending');
        $response->assertViewHas('overduePayments');
        $response->assertViewHas('upcomingPayments');
        $response->assertViewHas('recentPayments');

        // Verify data accuracy
        $this->assertEquals($this->client->id, $response->viewData('client')->id);
        $this->assertEquals(1, $response->viewData('totalContracts'));
        $this->assertEquals(1, $response->viewData('activeContracts'));
        $this->assertEquals(1500000, $response->viewData('totalPaid')); // 3 payments of 500000
        $this->assertEquals(1, $response->viewData('overduePayments')); // 1 overdue payment
    }

    /** @test */
    public function client_dashboard_shows_contract_details()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('dashboard'));

        $contracts = $response->viewData('contracts');

        $this->assertCount(1, $contracts);
        $this->assertEquals($this->contract->id, $contracts->first()->id);
    }

    /** @test */
    public function client_dashboard_shows_upcoming_payments()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('dashboard'));

        $upcomingPayments = $response->viewData('upcomingPayments');

        // Should have payments within the next 30 days
        $this->assertGreaterThanOrEqual(1, $upcomingPayments->count());
    }

    /** @test */
    public function client_dashboard_shows_recent_payments()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('dashboard'));

        $recentPayments = $response->viewData('recentPayments');

        // Should have 3 paid payments
        $this->assertEquals(3, $recentPayments->count());

        // Verify all are paid
        foreach ($recentPayments as $payment) {
            $this->assertEquals('pagado', $payment->status);
        }
    }

    /** @test */
    public function unauthenticated_user_cannot_access_dashboard()
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function client_with_multiple_contracts_sees_all()
    {
        // Create another motorcycle and contract
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

        $response = $this->actingAs($this->clientUser)
            ->get(route('dashboard'));

        $this->assertEquals(2, $response->viewData('totalContracts'));
        $this->assertEquals(2, $response->viewData('activeContracts'));
    }

    /** @test */
    public function client_dashboard_calculates_total_paid_correctly()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('dashboard'));

        $totalPaid = $response->viewData('totalPaid');

        // 3 payments x 500,000 = 1,500,000
        $this->assertEquals(1500000, $totalPaid);
    }

    /** @test */
    public function client_dashboard_calculates_total_pending_correctly()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('dashboard'));

        $totalPending = $response->viewData('totalPending');

        // 9 pending/overdue payments x 500,000 = 4,500,000
        $this->assertEquals(4500000, $totalPending);
    }
}
