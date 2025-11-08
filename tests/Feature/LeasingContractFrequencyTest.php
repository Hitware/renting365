<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Client;
use App\Models\Motorcycle;
use App\Models\LeasingContract;

class LeasingContractFrequencyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'RolesAndPermissionsSeeder']);
    }

    /** @test */
    public function contrato_puede_crearse_con_frecuencia_diaria()
    {
        $contract = LeasingContract::factory()->create([
            'payment_frequency' => 'diaria',
        ]);

        $this->assertEquals('diaria', $contract->payment_frequency);
    }

    /** @test */
    public function contrato_puede_crearse_con_frecuencia_semanal()
    {
        $contract = LeasingContract::factory()->create([
            'payment_frequency' => 'semanal',
        ]);

        $this->assertEquals('semanal', $contract->payment_frequency);
    }

    /** @test */
    public function contrato_puede_crearse_con_frecuencia_quincenal()
    {
        $contract = LeasingContract::factory()->create([
            'payment_frequency' => 'quincenal',
        ]);

        $this->assertEquals('quincenal', $contract->payment_frequency);
    }

    /** @test */
    public function contrato_puede_crearse_con_frecuencia_mensual()
    {
        $contract = LeasingContract::factory()->create([
            'payment_frequency' => 'mensual',
        ]);

        $this->assertEquals('mensual', $contract->payment_frequency);
    }

    /** @test */
    public function contrato_tiene_frecuencia_mensual_por_defecto()
    {
        $contract = LeasingContract::factory()->create();

        $this->assertEquals('mensual', $contract->payment_frequency);
    }

    /** @test */
    public function contrato_almacena_frecuencia_correctamente_en_base_datos()
    {
        $client = Client::factory()->create();
        $motorcycle = Motorcycle::factory()->create();

        $contract = LeasingContract::create([
            'contract_number' => 'TEST-001',
            'client_id' => $client->id,
            'motorcycle_id' => $motorcycle->id,
            'contract_date' => now(),
            'start_date' => now(),
            'end_date' => now()->addMonths(12),
            'motorcycle_value' => 10000000,
            'initial_payment' => 2000000,
            'financed_amount' => 8000000,
            'term_months' => 12,
            'monthly_payment' => 700000,
            'interest_rate' => 2.5,
            'payment_day' => 15,
            'payment_frequency' => 'quincenal',
            'status' => 'active',
        ]);

        $this->assertDatabaseHas('leasing_contracts', [
            'id' => $contract->id,
            'payment_frequency' => 'quincenal',
        ]);
    }
}
