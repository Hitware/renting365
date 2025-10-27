<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidatacreditoService
{
    private $apiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.midatacredito.url', 'https://api.midatacredito.com');
        $this->apiKey = config('services.midatacredito.key');
    }

    public function queryClient(Client $client): array
    {
        try {
            // Simulación de respuesta (reemplazar con llamada real a API)
            $response = $this->simulateApiCall($client);

            return [
                'score' => $response['score'],
                'risk_level' => $this->calculateRiskLevel($response['score']),
                'active_credits_count' => $response['active_credits_count'],
                'total_debt' => $response['total_debt'],
                'overdue_debt' => $response['overdue_debt'],
                'worst_status' => $response['worst_status'],
                'credit_cards_count' => $response['credit_cards_count'] ?? 0,
                'last_query_date' => $response['last_query_date'] ?? null,
                'inquiries_last_6_months' => $response['inquiries_last_6_months'] ?? 0,
                'has_legal_proceedings' => $response['has_legal_proceedings'] ?? false,
            ];

        } catch (\Exception $e) {
            Log::error('Error consultando Midatacrédito: ' . $e->getMessage());
            throw new \Exception('Error al consultar Midatacrédito. Por favor intente nuevamente.');
        }
    }

    private function simulateApiCall(Client $client): array
    {
        // Simulación - Reemplazar con llamada real
        return [
            'score' => rand(500, 850),
            'active_credits_count' => rand(0, 5),
            'total_debt' => rand(0, 50000000),
            'overdue_debt' => rand(0, 1000000),
            'worst_status' => 'al_dia',
            'credit_cards_count' => rand(0, 3),
            'inquiries_last_6_months' => rand(0, 10),
            'has_legal_proceedings' => false
        ];
    }

    private function calculateRiskLevel(int $score): string
    {
        return match(true) {
            $score >= 750 => 'bajo',
            $score >= 650 => 'medio',
            $score >= 550 => 'alto',
            default => 'muy_alto'
        };
    }

    public function canQuery(Client $client): bool
    {
        $lastQuery = $client->midatacredito()->latest()->first();
        
        if (!$lastQuery) {
            return true;
        }

        // Permitir nueva consulta solo después de 30 días
        return $lastQuery->query_date->diffInDays(now()) >= 30;
    }
}
