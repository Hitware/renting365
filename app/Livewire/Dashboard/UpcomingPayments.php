<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\LeasingPayment;
use Carbon\Carbon;

class UpcomingPayments extends Component
{
    public $filter = 'today'; // today, week

    public function render()
    {
        $startDate = now()->startOfDay();
        $endDate = $this->filter === 'today' 
            ? now()->endOfDay() 
            : now()->addDays(7)->endOfDay();

        $upcomingPayments = LeasingPayment::with(['contract.client', 'contract.motorcycle'])
            ->whereIn('status', ['pendiente'])
            ->whereBetween('due_date', [$startDate, $endDate])
            ->whereHas('contract', function($query) {
                $query->where('status', 'activo');
            })
            ->orderBy('due_date')
            ->get()
            ->map(function($payment) {
                $daysUntil = now()->diffInDays($payment->due_date, false);
                return [
                    'payment' => $payment,
                    'client' => $payment->contract->client,
                    'contract' => $payment->contract,
                    'motorcycle' => $payment->contract->motorcycle,
                    'days_until' => $daysUntil,
                    'is_today' => $payment->due_date->isToday(),
                    'priority' => $daysUntil <= 0 ? 'high' : ($daysUntil <= 2 ? 'medium' : 'low')
                ];
            });

        $totalAmount = $upcomingPayments->sum(fn($item) => $item['payment']->amount);
        $todayCount = $upcomingPayments->where('is_today', true)->count();

        return view('livewire.dashboard.upcoming-payments', [
            'upcomingPayments' => $upcomingPayments,
            'totalAmount' => $totalAmount,
            'todayCount' => $todayCount
        ]);
    }
}
