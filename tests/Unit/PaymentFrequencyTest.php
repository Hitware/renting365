<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class PaymentFrequencyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function calcula_fecha_siguiente_pago_diario()
    {
        $startDate = Carbon::parse('2025-01-01');
        $nextDate = $startDate->copy()->addDays(1);
        
        $this->assertEquals('2025-01-02', $nextDate->format('Y-m-d'));
    }

    /** @test */
    public function calcula_fecha_siguiente_pago_semanal()
    {
        $startDate = Carbon::parse('2025-01-01');
        $nextDate = $startDate->copy()->addWeeks(1);
        
        $this->assertEquals('2025-01-08', $nextDate->format('Y-m-d'));
    }

    /** @test */
    public function calcula_fecha_siguiente_pago_quincenal()
    {
        $startDate = Carbon::parse('2025-01-01');
        $nextDate = $startDate->copy()->addWeeks(2);
        
        $this->assertEquals('2025-01-15', $nextDate->format('Y-m-d'));
    }

    /** @test */
    public function calcula_fecha_siguiente_pago_mensual()
    {
        $startDate = Carbon::parse('2025-01-15');
        $nextDate = $startDate->copy()->addMonths(1);
        
        $this->assertEquals('2025-02-15', $nextDate->format('Y-m-d'));
    }

    /** @test */
    public function calcula_multiples_pagos_diarios()
    {
        $startDate = Carbon::parse('2025-01-01');
        $payments = [];
        
        for ($i = 0; $i < 5; $i++) {
            $payments[] = $startDate->copy()->addDays($i)->format('Y-m-d');
        }
        
        $this->assertEquals([
            '2025-01-01',
            '2025-01-02',
            '2025-01-03',
            '2025-01-04',
            '2025-01-05',
        ], $payments);
    }

    /** @test */
    public function calcula_multiples_pagos_semanales()
    {
        $startDate = Carbon::parse('2025-01-01');
        $payments = [];
        
        for ($i = 0; $i < 4; $i++) {
            $payments[] = $startDate->copy()->addWeeks($i)->format('Y-m-d');
        }
        
        $this->assertEquals([
            '2025-01-01',
            '2025-01-08',
            '2025-01-15',
            '2025-01-22',
        ], $payments);
    }

    /** @test */
    public function calcula_multiples_pagos_quincenales()
    {
        $startDate = Carbon::parse('2025-01-01');
        $payments = [];
        
        for ($i = 0; $i < 3; $i++) {
            $payments[] = $startDate->copy()->addWeeks($i * 2)->format('Y-m-d');
        }
        
        $this->assertEquals([
            '2025-01-01',
            '2025-01-15',
            '2025-01-29',
        ], $payments);
    }

    /** @test */
    public function calcula_multiples_pagos_mensuales()
    {
        $startDate = Carbon::parse('2025-01-15');
        $payments = [];
        
        for ($i = 0; $i < 6; $i++) {
            $payments[] = $startDate->copy()->addMonths($i)->format('Y-m-d');
        }
        
        $this->assertEquals([
            '2025-01-15',
            '2025-02-15',
            '2025-03-15',
            '2025-04-15',
            '2025-05-15',
            '2025-06-15',
        ], $payments);
    }
}
