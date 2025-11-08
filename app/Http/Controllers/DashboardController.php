<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeasingContract;
use App\Models\LeasingPayment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Si el usuario es un cliente, mostrar el dashboard de cliente
        if ($user->client) {
            return $this->clientDashboard($user);
        }

        // Si el usuario es admin o asesor, mostrar el dashboard administrativo
        return $this->adminDashboard($user);
    }

    private function clientDashboard($user)
    {
        $client = $user->client;

        // Obtener todos los contratos del cliente
        $contracts = LeasingContract::with(['motorcycle', 'payments'])
            ->where('client_id', $client->id)
            ->whereIn('status', ['activo', 'mora', 'completado'])
            ->get();

        // Calcular estadísticas generales
        $totalContracts = $contracts->count();
        $activeContracts = $contracts->whereIn('status', ['activo', 'mora'])->count();

        // Obtener todos los pagos del cliente
        $allPayments = LeasingPayment::whereHas('contract', function($query) use ($client) {
            $query->where('client_id', $client->id);
        })->get();

        $totalPaid = $allPayments->where('status', 'pagado')->sum('amount');
        $totalPending = $allPayments->whereIn('status', ['pendiente', 'atrasado'])->sum('amount');
        $overduePayments = $allPayments->where('status', 'atrasado')->count();

        // Próximos pagos (próximos 30 días)
        $upcomingPayments = LeasingPayment::with(['contract.motorcycle'])
            ->whereHas('contract', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->whereIn('status', ['pendiente', 'atrasado'])
            ->whereBetween('due_date', [now(), now()->addDays(30)])
            ->orderBy('due_date')
            ->limit(5)
            ->get();

        // Últimos pagos realizados
        $recentPayments = LeasingPayment::with(['contract.motorcycle'])
            ->whereHas('contract', function($query) use ($client) {
                $query->where('client_id', $client->id);
            })
            ->where('status', 'pagado')
            ->orderBy('paid_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboards.client', compact(
            'client',
            'contracts',
            'totalContracts',
            'activeContracts',
            'totalPaid',
            'totalPending',
            'overduePayments',
            'upcomingPayments',
            'recentPayments'
        ));
    }

    private function adminDashboard($user)
    {
        // Este es el dashboard actual para admin/asesor
        return view('dashboard');
    }
}
