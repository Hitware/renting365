<?php

namespace App\Livewire\Payments;

use Livewire\Component;
use App\Models\LeasingContract;
use App\Models\LeasingPayment;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentRegistration extends Component
{
    public $contractId = null;
    public $search = '';
    public $selectedContract = null;
    public $selectedPayment = null;
    public $searchResults = [];

    // Datos del pago
    public $amount_received;
    public $payment_date;
    public $payment_method = 'efectivo';
    public $reference_number;
    public $notes;

    public $showSuccess = false;
    public $showModal = false;
    
    protected $listeners = ['openPaymentModal'];

    protected $rules = [
        'amount_received' => 'required|numeric|min:0',
        'payment_date' => 'required|date|before_or_equal:today',
        'payment_method' => 'required|in:efectivo,transferencia,tarjeta,cheque,pse',
        'reference_number' => 'nullable|string|max:100',
        'notes' => 'nullable|string|max:500'
    ];

    protected $messages = [
        'amount_received.required' => 'El monto recibido es obligatorio',
        'amount_received.numeric' => 'El monto debe ser un número',
        'amount_received.min' => 'El monto debe ser mayor a 0',
        'payment_date.required' => 'La fecha de pago es obligatoria',
        'payment_date.date' => 'Ingresa una fecha válida',
        'payment_date.before_or_equal' => 'La fecha no puede ser futura',
        'payment_method.required' => 'Selecciona un método de pago',
    ];

    public function mount($contractId = null)
    {
        $this->payment_date = now()->format('Y-m-d');
        $this->contractId = $contractId;
    }
    
    public function openPaymentModal($contractId)
    {
        $this->selectContract($contractId);
    }

    public function updatedSearch()
    {
        if (strlen($this->search) >= 3) {
            $this->searchContracts();
        } else {
            $this->searchResults = [];
        }
    }

    public function searchContracts()
    {
        $this->searchResults = LeasingContract::with(['client', 'motorcycle', 'payments'])
            ->where('status', 'activo')
            ->where(function($query) {
                $query->where('contract_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('client', function($q) {
                        $q->where('full_name', 'like', '%' . $this->search . '%')
                          ->orWhere('document_number', 'like', '%' . $this->search . '%');
                    });
            })
            ->limit(10)
            ->get()
            ->map(function($contract) {
                $nextPayment = $contract->payments()
                    ->where('status', 'pendiente')
                    ->orderBy('payment_number')
                    ->first();

                return [
                    'id' => $contract->id,
                    'contract_number' => $contract->contract_number,
                    'client_name' => $contract->client->full_name,
                    'client_document' => $contract->client->document_number,
                    'motorcycle' => $contract->motorcycle->brand . ' ' . $contract->motorcycle->model,
                    'next_payment' => $nextPayment,
                    'has_overdue' => $contract->payments()
                        ->where('status', 'atrasado')
                        ->exists()
                ];
            });
    }

    public function selectContract($contractId)
    {
        $this->selectedContract = LeasingContract::with(['client', 'motorcycle', 'payments'])
            ->findOrFail($contractId);

        // Buscar el siguiente pago pendiente o el primer atrasado
        $this->selectedPayment = $this->selectedContract->payments()
            ->whereIn('status', ['pendiente', 'atrasado'])
            ->orderBy('payment_number')
            ->first();

        if ($this->selectedPayment) {
            $this->amount_received = $this->selectedPayment->amount;
            $this->showModal = true;
        }

        $this->searchResults = [];
        $this->search = '';
    }

    public function registerPayment()
    {
        $this->validate();

        if (!$this->selectedPayment) {
            session()->flash('error', 'No hay un pago seleccionado');
            return;
        }

        DB::transaction(function () {
            // Actualizar el pago
            $this->selectedPayment->update([
                'status' => 'pagado',
                'paid_at' => $this->payment_date,
                'amount_paid' => $this->amount_received,
                'payment_method' => $this->payment_method,
                'reference_number' => $this->reference_number,
                'notes' => $this->notes,
                'received_by' => auth()->id()
            ]);

            // Verificar si hay pagos atrasados y actualizar el estado del contrato
            $overduePayments = $this->selectedContract->payments()
                ->where('status', 'atrasado')
                ->count();

            if ($overduePayments == 0) {
                // Si ya no hay pagos atrasados, cambiar el estado del contrato
                if ($this->selectedContract->status == 'mora') {
                    $this->selectedContract->update(['status' => 'activo']);
                }
            }

            // Verificar si era el último pago
            $pendingPayments = $this->selectedContract->payments()
                ->whereIn('status', ['pendiente', 'atrasado'])
                ->count();

            if ($pendingPayments == 0) {
                $this->selectedContract->update(['status' => 'completado']);
            }

            // Registrar actividad
            activity()
                ->causedBy(auth()->user())
                ->performedOn($this->selectedPayment)
                ->withProperties([
                    'contract_number' => $this->selectedContract->contract_number,
                    'payment_number' => $this->selectedPayment->payment_number,
                    'amount' => $this->amount_received,
                    'method' => $this->payment_method
                ])
                ->log('Pago registrado');
        });

        $this->showSuccess = true;
        $this->showModal = false;
        $this->reset(['selectedContract', 'selectedPayment', 'amount_received', 'reference_number', 'notes']);
        $this->payment_date = now()->format('Y-m-d');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['selectedContract', 'selectedPayment', 'amount_received', 'reference_number', 'notes']);
    }

    public function closeSuccess()
    {
        $this->showSuccess = false;
    }

    public function render()
    {
        return view('livewire.payments.payment-registration');
    }
}
