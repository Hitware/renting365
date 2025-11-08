<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Client;
use App\Models\LeasingContract;
use App\Models\LeasingPayment;
use App\Models\Motorcycle;

class PaymentAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    /** @test */
    public function cliente_puede_ver_solo_pagos_de_sus_contratos()
    {
        $client = Client::factory()->create();
        $user = User::factory()->create();
        $user->assignRole('client');
        $client->user_id = $user->id;
        $client->save();

        $motorcycle = Motorcycle::factory()->create();
        $ownContract = LeasingContract::factory()->create([
            'client_id' => $client->id,
            'motorcycle_id' => $motorcycle->id,
        ]);

        $ownPayment = LeasingPayment::factory()->create([
            'leasing_contract_id' => $ownContract->id,
        ]);

        $otherClient = Client::factory()->create();
        $otherMotorcycle = Motorcycle::factory()->create();
        $otherContract = LeasingContract::factory()->create([
            'client_id' => $otherClient->id,
            'motorcycle_id' => $otherMotorcycle->id,
        ]);

        $otherPayment = LeasingPayment::factory()->create([
            'leasing_contract_id' => $otherContract->id,
        ]);

        $response = $this->actingAs($user)->get(route('payments.index'));

        $response->assertStatus(200);
        $response->assertSee(number_format($ownPayment->amount, 0, ',', '.'));
        $response->assertDontSee(number_format($otherPayment->amount, 0, ',', '.'));
    }

    /** @test */
    public function cliente_puede_ver_detalle_de_pago_de_su_contrato()
    {
        $client = Client::factory()->create();
        $user = User::factory()->create();
        $user->assignRole('client');
        $client->user_id = $user->id;
        $client->save();

        $motorcycle = Motorcycle::factory()->create();
        $contract = LeasingContract::factory()->create([
            'client_id' => $client->id,
            'motorcycle_id' => $motorcycle->id,
        ]);

        $payment = LeasingPayment::factory()->create([
            'leasing_contract_id' => $contract->id,
        ]);

        $response = $this->actingAs($user)->get(route('payments.show', $payment));

        $response->assertStatus(200);
    }

    /** @test */
    public function cliente_no_puede_ver_pago_de_otro_cliente()
    {
        $client = Client::factory()->create();
        $user = User::factory()->create();
        $user->assignRole('client');
        $client->user_id = $user->id;
        $client->save();

        $otherClient = Client::factory()->create();
        $motorcycle = Motorcycle::factory()->create();
        $otherContract = LeasingContract::factory()->create([
            'client_id' => $otherClient->id,
            'motorcycle_id' => $motorcycle->id,
        ]);

        $otherPayment = LeasingPayment::factory()->create([
            'leasing_contract_id' => $otherContract->id,
        ]);

        $response = $this->actingAs($user)->get(route('payments.show', $otherPayment));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_puede_ver_todos_los_pagos()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $client1 = Client::factory()->create();
        $motorcycle1 = Motorcycle::factory()->create();
        $contract1 = LeasingContract::factory()->create([
            'client_id' => $client1->id,
            'motorcycle_id' => $motorcycle1->id,
        ]);
        $payment1 = LeasingPayment::factory()->create([
            'leasing_contract_id' => $contract1->id,
        ]);

        $client2 = Client::factory()->create();
        $motorcycle2 = Motorcycle::factory()->create();
        $contract2 = LeasingContract::factory()->create([
            'client_id' => $client2->id,
            'motorcycle_id' => $motorcycle2->id,
        ]);
        $payment2 = LeasingPayment::factory()->create([
            'leasing_contract_id' => $contract2->id,
        ]);

        $response = $this->actingAs($admin)->get(route('payments.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function cliente_no_puede_acceder_a_crear_pago()
    {
        $user = User::factory()->create();
        $user->assignRole('client');

        $response = $this->actingAs($user)->get(route('payments.create'));

        $response->assertStatus(403);
    }
}
