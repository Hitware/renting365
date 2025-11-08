<?php

namespace App\Http\Controllers;

use App\Models\LeasingPayment;
use App\Models\LeasingContract;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('payments.view-own');
            $payments = LeasingPayment::with(['contract.client', 'contract.motorcycle', 'receivedBy'])
                ->whereHas('contract', function($q) use ($user) {
                    $q->where('client_id', $user->client->id);
                })
                ->orderBy('due_date', 'desc')
                ->paginate(20);
        } else {
            $this->authorize('payments.view');
            $payments = LeasingPayment::with(['contract.client', 'contract.motorcycle', 'receivedBy'])
                ->orderBy('due_date', 'desc')
                ->paginate(20);
        }

        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $this->authorize('clients.create');
        return view('payments.create');
    }

    public function today()
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('payments.view-own');
            $todayPayments = LeasingPayment::with(['contract.client', 'contract.motorcycle'])
                ->whereHas('contract', function($q) use ($user) {
                    $q->where('client_id', $user->client->id);
                })
                ->whereDate('due_date', today())
                ->whereIn('status', ['pendiente', 'atrasado'])
                ->orderBy('due_date')
                ->get();
        } else {
            $this->authorize('payments.view');
            $todayPayments = LeasingPayment::with(['contract.client', 'contract.motorcycle'])
                ->whereDate('due_date', today())
                ->whereIn('status', ['pendiente', 'atrasado'])
                ->orderBy('due_date')
                ->get();
        }

        return view('payments.today', compact('todayPayments'));
    }

    public function overdue()
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('payments.view-own');
            $overduePayments = LeasingPayment::with(['contract.client', 'contract.motorcycle'])
                ->whereHas('contract', function($q) use ($user) {
                    $q->where('client_id', $user->client->id);
                })
                ->where('status', 'atrasado')
                ->orderBy('due_date')
                ->get();
        } else {
            $this->authorize('payments.view');
            $overduePayments = LeasingPayment::with(['contract.client', 'contract.motorcycle'])
                ->where('status', 'atrasado')
                ->orderBy('due_date')
                ->get();
        }

        return view('payments.overdue', compact('overduePayments'));
    }

    public function upcoming()
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('payments.view-own');
            $upcomingPayments = LeasingPayment::with(['contract.client', 'contract.motorcycle'])
                ->whereHas('contract', function($q) use ($user) {
                    $q->where('client_id', $user->client->id);
                })
                ->where('status', 'pendiente')
                ->whereBetween('due_date', [today(), today()->addDays(15)])
                ->orderBy('due_date')
                ->get();
        } else {
            $this->authorize('payments.view');
            $upcomingPayments = LeasingPayment::with(['contract.client', 'contract.motorcycle'])
                ->where('status', 'pendiente')
                ->whereBetween('due_date', [today(), today()->addDays(15)])
                ->orderBy('due_date')
                ->get();
        }

        return view('payments.upcoming', compact('upcomingPayments'));
    }

    public function history(Request $request)
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('payments.view-own');
            $query = LeasingPayment::with(['contract.client', 'contract.motorcycle', 'receivedBy'])
                ->whereHas('contract', function($q) use ($user) {
                    $q->where('client_id', $user->client->id);
                })
                ->where('status', 'pagado');
        } else {
            $this->authorize('payments.view');
            $query = LeasingPayment::with(['contract.client', 'contract.motorcycle', 'receivedBy'])
                ->where('status', 'pagado');
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('paid_at', [
                $request->input('start_date'),
                $request->input('end_date')
            ]);
        }

        $payments = $query->orderBy('paid_at', 'desc')->paginate(20);

        return view('payments.history', compact('payments'));
    }

    public function show(LeasingPayment $payment)
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('payments.view-own');
            if ($payment->contract->client_id !== $user->client->id) {
                abort(403, 'No tienes acceso a este pago');
            }
        } else {
            $this->authorize('payments.view');
        }

        $payment->load(['contract.client', 'contract.motorcycle', 'receivedBy']);

        return view('payments.show', compact('payment'));
    }
}
