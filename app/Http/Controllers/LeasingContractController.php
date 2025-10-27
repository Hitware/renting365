<?php

namespace App\Http\Controllers;

use App\Models\LeasingContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeasingContractController extends Controller
{
    public function index()
    {
        $this->authorize('clients.view');

        $contracts = LeasingContract::with(['client', 'motorcycle'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('leasing.index', compact('contracts'));
    }

    public function create()
    {
        $this->authorize('clients.create');
        return view('leasing.create');
    }

    public function show(LeasingContract $leasingContract)
    {
        $this->authorize('clients.view');
        
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
        $this->authorize('clients.view');

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
        $this->authorize('clients.view');
        
        $leasingContract->load(['client', 'motorcycle', 'payments' => function($query) {
            $query->orderBy('payment_number');
        }]);
        
        return view('leasing.print-schedule', ['contract' => $leasingContract]);
    }

    public function printContract(LeasingContract $leasingContract)
    {
        $this->authorize('clients.view');
        
        $leasingContract->load(['client', 'motorcycle', 'payments' => function($query) {
            $query->orderBy('payment_number');
        }]);
        
        return view('leasing.print-contract', ['contract' => $leasingContract]);
    }
}
