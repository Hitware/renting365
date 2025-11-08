<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\LeasingPayment;
use Carbon\Carbon;

class OverduePayments extends Component
{
    public function render()
    {
        $overduePayments = LeasingPayment::with(['contract.client', 'contract.motorcycle'])
            ->whereIn('status', ['pendiente', 'vencido'])
            ->where('due_date', '<', now()->startOfDay())
            ->whereHas('contract', function($query) {
                $query->whereIn('status', ['activo', 'mora']);
            })
            ->orderBy('due_date')
            ->get()
            ->map(function($payment) {
                $daysOverdue = now()->diffInDays($payment->due_date);
                return [
                    'payment' => $payment,
                    'client' => $payment->contract->client,
                    'contract' => $payment->contract,
                    'motorcycle' => $payment->contract->motorcycle,
                    'days_overdue' => $daysOverdue,
                    'priority' => $daysOverdue > 30 ? 'critical' : ($daysOverdue > 15 ? 'high' : 'medium')
                ];
            });

        $totalOverdue = $overduePayments->sum(fn($item) => $item['payment']->amount);
        $criticalCount = $overduePayments->where('priority', 'critical')->count();

        return view('livewire.dashboard.overdue-payments', [
            'overduePayments' => $overduePayments,
            'totalOverdue' => $totalOverdue,
            'criticalCount' => $criticalCount
        ]);
    }
}
