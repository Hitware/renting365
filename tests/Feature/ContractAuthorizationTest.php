<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Client;
use App\Models\LeasingContract;
use App\Models\Motorcycle;

class ContractAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    /** @test */
    public function cliente_puede_ver_solo_sus_propios_contratos()
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

        $otherClient = Client::factory()->create();
        $otherMotorcycle = Motorcycle::factory()->create();
        $otherContract = LeasingContract::factory()->create([
            'client_id' => $otherClient->id,
            'motorcycle_id' => $otherMotorcycle->id,
        ]);

        $response = $this->actingAs($user)->get(route('leasing-contracts.index'));

        $response->assertStatus(200);
        $response->assertSee($ownContract->contract_number);
        $response->assertDontSee($otherContract->contract_number);
    }

    /** @test */
    public function cliente_puede_ver_detalle_de_su_propio_contrato()
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

        $response = $this->actingAs($user)->get(route('leasing-contracts.show', $contract));

        $response->assertStatus(200);
    }

    /** @test */
    public function cliente_no_puede_ver_contrato_de_otro_cliente()
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

        $response = $this->actingAs($user)->get(route('leasing-contracts.show', $otherContract));

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_puede_ver_todos_los_contratos()
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $client1 = Client::factory()->create();
        $motorcycle1 = Motorcycle::factory()->create();
        $contract1 = LeasingContract::factory()->create([
            'client_id' => $client1->id,
            'motorcycle_id' => $motorcycle1->id,
        ]);

        $client2 = Client::factory()->create();
        $motorcycle2 = Motorcycle::factory()->create();
        $contract2 = LeasingContract::factory()->create([
            'client_id' => $client2->id,
            'motorcycle_id' => $motorcycle2->id,
        ]);

        $response = $this->actingAs($admin)->get(route('leasing-contracts.index'));

        $response->assertStatus(200);
        $response->assertSee($contract1->contract_number);
        $response->assertSee($contract2->contract_number);
    }

    /** @test */
    public function cliente_no_puede_acceder_a_crear_contrato()
    {
        $user = User::factory()->create();
        $user->assignRole('client');

        $response = $this->actingAs($user)->get(route('leasing-contracts.create'));

        $response->assertStatus(403);
    }

    /** @test */
    public function cliente_no_puede_acceder_a_editar_contrato()
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

        $response = $this->actingAs($user)->get(route('leasing-contracts.edit', $contract));

        $response->assertStatus(403);
    }
}
