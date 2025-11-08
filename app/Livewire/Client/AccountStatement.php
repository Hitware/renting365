<?php

namespace App\Livewire\Client;

use Livewire\Component;
use App\Models\Client;
use App\Models\LeasingContract;

class AccountStatement extends Component
{
    public $client;
    public $contracts;
    public $selectedContract = null;

    public function mount($clientId = null)
    {
        // Si es un cliente con usuario, mostrar sus propios contratos
        if (!$clientId && auth()->user()->client) {
            $this->client = auth()->user()->client;
        } elseif ($clientId) {
            // Si es admin/asesor viendo un cliente específico
            $this->client = Client::findOrFail($clientId);
        } else {
            abort(403, 'No tienes acceso a esta información');
        }

        $this->loadContracts();

        // Seleccionar el primer contrato activo por defecto
        if ($this->contracts->isNotEmpty()) {
            $this->selectedContract = $this->contracts->first()->id;
        }
    }

    public function loadContracts()
    {
        $this->contracts = LeasingContract::with(['motorcycle', 'payments' => function($query) {
                $query->orderBy('payment_number');
            }])
            ->where('client_id', $this->client->id)
            ->whereIn('status', ['activo', 'mora', 'completado'])
            ->get()
            ->map(function($contract) {
                return [
                    'id' => $contract->id,
                    'contract_number' => $contract->contract_number,
                    'motorcycle' => $contract->motorcycle->brand . ' ' . $contract->motorcycle->model . ' - ' . $contract->motorcycle->plate,
                    'start_date' => $contract->start_date,
                    'status' => $contract->status,
                    'status_label' => $this->getStatusLabel($contract->status),
                    'status_color' => $this->getStatusColor($contract->status),
                    'monthly_payment' => $contract->monthly_payment,
                    'term_months' => $contract->term_months,
                    'total_paid' => $contract->payments->where('status', 'pagado')->count(),
                    'total_pending' => $contract->payments->whereIn('status', ['pendiente', 'atrasado'])->count(),
                    'pending_balance' => $contract->payments->whereIn('status', ['pendiente', 'atrasado'])->sum('amount'),
                    'next_payment' => $contract->payments()->whereIn('status', ['pendiente', 'atrasado'])->orderBy('payment_number')->first(),
                    'payments' => $contract->payments,
                    'raw_contract' => $contract
                ];
            });
    }

    public function selectContract($contractId)
    {
        $this->selectedContract = $contractId;
    }

    public function getSelectedContractData()
    {
        return $this->contracts->firstWhere('id', $this->selectedContract);
    }

    private function getStatusLabel($status)
    {
        return match($status) {
            'activo' => 'Al Día',
            'mora' => 'En Mora',
            'completado' => 'Completado',
            'cancelado' => 'Cancelado',
            default => $status
        };
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'activo' => 'bg-green-100 text-green-800',
            'mora' => 'bg-red-100 text-red-800',
            'completado' => 'bg-blue-100 text-blue-800',
            'cancelado' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function render()
    {
        $selectedContractData = $this->getSelectedContractData();

        return view('livewire.client.account-statement', [
            'selectedContractData' => $selectedContractData
        ]);
    }
}
