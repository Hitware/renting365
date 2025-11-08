<?php

namespace App\Http\Controllers;

use App\Models\LeasingContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeasingContractController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Si es cliente, solo ver sus contratos
        if ($user->hasRole('client')) {
            $this->authorize('contracts.view-own');
            $contracts = LeasingContract::with(['client', 'motorcycle'])
                ->where('client_id', $user->client->id)
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        } else {
            $this->authorize('contracts.view');
            $contracts = LeasingContract::with(['client', 'motorcycle'])
                ->orderBy('created_at', 'desc')
                ->paginate(15);
        }

        return view('leasing.index', compact('contracts'));
    }

    public function create()
    {
        $this->authorize('clients.create');
        return view('leasing.create');
    }

    public function show(LeasingContract $leasingContract)
    {
        $user = auth()->user();
        
        // Verificar si el usuario tiene un cliente asociado y es su contrato
        if ($user->client && $leasingContract->client_id === $user->client->id) {
            // El usuario puede ver su propio contrato
        } elseif ($user->can('contracts.view')) {
            // Usuario con permiso general puede ver cualquier contrato
        } else {
            abort(403, 'No tienes acceso a este contrato');
        }
        
        $leasingContract->load([
            'client',
            'motorcycle',
            'payments' => function($query) {
                $query->orderBy('payment_number');
            },
            'maintenances' => function($query) {
                $query->orderBy('scheduled_date', 'desc');
            }
        ]);
        
        // Debug
        \Log::info('Contract loaded', [
            'id' => $leasingContract->id,
            'client_id' => $leasingContract->client_id,
            'motorcycle_id' => $leasingContract->motorcycle_id,
            'has_client' => $leasingContract->client ? 'yes' : 'no',
            'has_motorcycle' => $leasingContract->motorcycle ? 'yes' : 'no',
            'payments_count' => $leasingContract->payments->count()
        ]);
        
        $contract = $leasingContract;
        return view('leasing.show', compact('contract'));
    }

    public function viewContract(LeasingContract $leasingContract)
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('contracts.view-own');
            if ($leasingContract->client_id !== $user->client->id) {
                abort(403);
            }
        } else {
            $this->authorize('contracts.view');
        }

        if (!$leasingContract->signed_contract_path) {
            abort(404);
        }

        $path = Storage::disk('private')->path($leasingContract->signed_contract_path);
        
        return response()->file($path, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $leasingContract->contract_number . '.pdf"'
        ]);
    }

    public function printPaymentSchedule(LeasingContract $leasingContract)
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('contracts.view-own');
            if ($leasingContract->client_id !== $user->client->id) {
                abort(403);
            }
        } else {
            $this->authorize('contracts.view');
        }
        
        $leasingContract->load(['client', 'motorcycle', 'payments' => function($query) {
            $query->orderBy('payment_number');
        }]);
        
        return view('leasing.print-schedule', ['contract' => $leasingContract]);
    }

    public function printContract(LeasingContract $leasingContract)
    {
        $user = auth()->user();
        
        if ($user->hasRole('client')) {
            $this->authorize('contracts.view-own');
            if ($leasingContract->client_id !== $user->client->id) {
                abort(403);
            }
        } else {
            $this->authorize('contracts.view');
        }
        
        $leasingContract->load(['client', 'motorcycle', 'payments' => function($query) {
            $query->orderBy('payment_number');
        }]);
        
        return view('leasing.print-contract', ['contract' => $leasingContract]);
    }
}
