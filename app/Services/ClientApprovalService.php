<?php

namespace App\Services;

use App\Models\Client;

class ClientApprovalService
{
    const MAX_DEBT_TO_INCOME_RATIO = 0.50;
    const MIN_DISPOSABLE_INCOME = 500000;
    const MIN_CREDIT_SCORE_AUTO_APPROVAL = 700;
    const MIN_EMPLOYMENT_MONTHS = 6;

    public function canAutoApprove(Client $client): bool
    {
        $checks = [
            'credit_score' => $this->checkCreditScore($client),
            'no_overdue_debts' => $this->checkOverdueDebts($client),
            'stable_employment' => $this->checkEmployment($client),
            'good_debt_ratio' => $this->checkDebtRatio($client),
            'all_documents_approved' => $this->checkDocuments($client),
            'references_verified' => $this->checkReferences($client)
        ];

        return !in_array(false, $checks, true);
    }

    public function requiresManagerApproval(Client $client, float $requestedAmount = 0): bool
    {
        return $requestedAmount > 10000000 ||
               ($client->credit_score && $client->credit_score < 650) ||
               ($client->latestMidatacredito && $client->latestMidatacredito->worst_status != 'al_dia');
    }

    public function calculateApprovalScore(Client $client): int
    {
        $score = 0;

        // Score crediticio (40 puntos)
        if ($client->credit_score >= 750) $score += 40;
        elseif ($client->credit_score >= 650) $score += 30;
        elseif ($client->credit_score >= 550) $score += 20;

        // Empleo estable (20 puntos)
        if ($client->currentEmployment) {
            $months = $client->currentEmployment->start_date->diffInMonths(now());
            if ($months >= 12) $score += 20;
            elseif ($months >= 6) $score += 15;
            elseif ($months >= 3) $score += 10;
        }

        // Capacidad financiera (20 puntos)
        if ($client->latestFinancial) {
            $ratio = $client->latestFinancial->debt_to_income_ratio ?? 1;
            if ($ratio <= 0.35) $score += 20;
            elseif ($ratio <= 0.45) $score += 15;
            elseif ($ratio <= 0.50) $score += 10;
        }

        // Documentación (10 puntos)
        $approvedDocs = $client->documents()->where('status', 'aprobado')->count();
        if ($approvedDocs >= 5) $score += 10;
        elseif ($approvedDocs >= 3) $score += 5;

        // Referencias (10 puntos)
        $verifiedRefs = $client->references()->where('verification_status', 'verificada')->count();
        if ($verifiedRefs >= 2) $score += 10;
        elseif ($verifiedRefs >= 1) $score += 5;

        return $score;
    }

    private function checkCreditScore(Client $client): bool
    {
        return $client->credit_score && $client->credit_score >= self::MIN_CREDIT_SCORE_AUTO_APPROVAL;
    }

    private function checkOverdueDebts(Client $client): bool
    {
        if (!$client->latestMidatacredito) return false;
        return $client->latestMidatacredito->overdue_debt == 0;
    }

    private function checkEmployment(Client $client): bool
    {
        if (!$client->currentEmployment) return false;
        $months = $client->currentEmployment->start_date->diffInMonths(now());
        return $months >= self::MIN_EMPLOYMENT_MONTHS;
    }

    private function checkDebtRatio(Client $client): bool
    {
        if (!$client->latestFinancial) return false;
        return ($client->latestFinancial->debt_to_income_ratio ?? 1) <= self::MAX_DEBT_TO_INCOME_RATIO;
    }

    private function checkDocuments(Client $client): bool
    {
        $requiredDocs = ['cedula_frontal', 'cedula_reverso', 'certificado_laboral', 'desprendible_pago', 'servicio_publico'];
        
        foreach ($requiredDocs as $docType) {
            $hasDoc = $client->documents()
                ->where('document_type', $docType)
                ->where('is_current_version', true)
                ->where('status', 'aprobado')
                ->exists();

            if (!$hasDoc) return false;
        }

        return true;
    }

    private function checkReferences(Client $client): bool
    {
        return $client->references()->where('verification_status', 'verificada')->count() >= 2;
    }
}
