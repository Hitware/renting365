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

class PaymentControllerTest extends TestCase
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
        Permission::create(['name' => 'clients.create']);
        $adminRole->givePermissionTo(['clients.view', 'clients.create']);

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
    public function admin_can_view_payments_index()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('payments.index'));

        $response->assertStatus(200);
        $response->assertViewIs('payments.index');
        $response->assertViewHas('payments');
    }

    /** @test */
    public function client_cannot_view_payments_index_without_permission()
    {
        $response = $this->actingAs($this->clientUser)
            ->get(route('payments.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_payment_creation_page()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('payments.create'));

        $response->assertStatus(200);
        $response->assertViewIs('payments.create');
    }

    /** @test */
    public function admin_can_view_today_payments()
    {
        // Create a payment for today
        LeasingPayment::factory()->create([
            'leasing_contract_id' => $this->contract->id,
            'due_date' => today(),
            'status' => 'pendiente',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->get(route('payments.today'));

        $response->assertStatus(200);
        $response->assertViewIs('payments.today');
        $response->assertViewHas('todayPayments');
    }

    /** @test */
    public function admin_can_view_overdue_payments()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('payments.overdue'));

        $response->assertStatus(200);
        $response->assertViewIs('payments.overdue');
        $response->assertViewHas('overduePayments');

        // Verify we have at least one overdue payment
        $overduePayments = $response->viewData('overduePayments');
        $this->assertGreaterThan(0, $overduePayments->count());
    }

    /** @test */
    public function admin_can_view_upcoming_payments()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('payments.upcoming'));

        $response->assertStatus(200);
        $response->assertViewIs('payments.upcoming');
        $response->assertViewHas('upcomingPayments');
    }

    /** @test */
    public function admin_can_view_payment_history()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('payments.history'));

        $response->assertStatus(200);
        $response->assertViewIs('payments.history');
        $response->assertViewHas('payments');
    }

    /** @test */
    public function payment_history_can_be_filtered_by_date()
    {
        $startDate = now()->subMonths(2)->format('Y-m-d');
        $endDate = now()->format('Y-m-d');

        $response = $this->actingAs($this->adminUser)
            ->get(route('payments.history', [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]));

        $response->assertStatus(200);
        $response->assertViewHas('payments');
    }

    /** @test */
    public function payment_statistics_are_accurate()
    {
        $response = $this->actingAs($this->adminUser)
            ->get(route('payments.overdue'));

        $overduePayments = $response->viewData('overduePayments');

        // We created 1 overdue payment in setUp
        $this->assertEquals(1, $overduePayments->count());

        // Verify the payment is actually overdue
        $overduePayment = $overduePayments->first();
        $this->assertEquals('atrasado', $overduePayment->status);
    }

    /** @test */
    public function only_authenticated_users_can_access_payment_routes()
    {
        $routes = [
            'payments.index',
            'payments.create',
            'payments.today',
            'payments.overdue',
            'payments.upcoming',
            'payments.history',
        ];

        foreach ($routes as $route) {
            $response = $this->get(route($route));
            $response->assertRedirect(route('login'));
        }
    }
}
