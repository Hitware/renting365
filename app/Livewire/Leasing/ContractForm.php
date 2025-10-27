<?php

namespace App\Livewire\Leasing;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Client;
use App\Models\Motorcycle;
use App\Models\LeasingContract;
use App\Services\LeasingCalculatorService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContractForm extends Component
{
    use WithFileUploads;

    public $client_id;
    public $motorcycle_id;
    public $motorcycle_value;
    public $initial_payment = 0;
    public $term_months = 12;
    public $monthly_rate = 2.5;
    public $payment_day = 5;
    public $start_date;
    public $signed_contract;
    public $notes;

    public $financed_amount;
    public $monthly_payment;
    public $total_interest;
    public $payment_schedule = [];
    public $showPreview = false;

    protected $rules = [
        'client_id' => 'required|exists:clients,id',
        'motorcycle_id' => 'required|exists:motorcycles,id',
        'motorcycle_value' => 'required|numeric|min:0',
        'initial_payment' => 'required|numeric|min:0',
        'term_months' => 'required|integer|min:6|max:60',
        'monthly_rate' => 'required|numeric|min:0|max:10',
        'payment_day' => 'required|integer|min:1|max:28',
        'start_date' => 'required|date|after_or_equal:today',
        'signed_contract' => 'required|file|mimes:pdf|max:10240'
    ];

    public function mount($client = null)
    {
        $this->start_date = now()->addDays(5)->format('Y-m-d');
        
        if ($client) {
            $clientModel = Client::where((new Client)->getRouteKeyName(), $client)->first();
            if ($clientModel) {
                $this->client_id = $clientModel->id;
            }
        }
    }

    public function updatedMotorcycleId($value)
    {
        if ($value) {
            $motorcycle = Motorcycle::find($value);
            $this->motorcycle_value = $motorcycle->purchase_price ?? 0;
        }
    }

    public function updatedMotorcycleValue()
    {
        $this->calculateFinancing();
    }

    public function updatedInitialPayment()
    {
        $this->calculateFinancing();
    }

    public function updatedTermMonths()
    {
        $this->calculateFinancing();
    }

    public function updatedMonthlyRate()
    {
        $this->calculateFinancing();
    }

    public function calculateFinancing()
    {
        if ($this->motorcycle_value && $this->initial_payment >= 0 && $this->term_months && $this->monthly_rate >= 0) {
            $calculator = new LeasingCalculatorService();
            
            $this->financed_amount = $this->motorcycle_value - $this->initial_payment;
            $this->monthly_payment = $calculator->calculateMonthlyPayment(
                $this->financed_amount,
                $this->monthly_rate,
                $this->term_months
            );
            $this->total_interest = $calculator->calculateTotalInterest(
                $this->financed_amount,
                $this->monthly_rate,
                $this->term_months
            );
        }
    }

    public function generatePreview()
    {
        $this->validate([
            'motorcycle_value' => 'required|numeric|min:0',
            'initial_payment' => 'required|numeric|min:0',
            'term_months' => 'required|integer|min:6|max:60',
            'monthly_rate' => 'required|numeric|min:0|max:10',
            'payment_day' => 'required|integer|min:1|max:28',
            'start_date' => 'required|date'
        ]);

        $calculator = new LeasingCalculatorService();
        $this->payment_schedule = $calculator->generatePaymentSchedule(
            $this->financed_amount,
            $this->monthly_rate,
            $this->term_months,
            Carbon::parse($this->start_date),
            $this->payment_day
        );

        $this->showPreview = true;
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $calculator = new LeasingCalculatorService();
            
            $contractNumber = 'LC-' . now()->format('Ymd') . '-' . str_pad(LeasingContract::count() + 1, 4, '0', STR_PAD_LEFT);
            
            $contractPath = $this->signed_contract->store('leasing_contracts', 'private');

            $endDate = Carbon::parse($this->start_date)->addMonths($this->term_months);

            $contract = LeasingContract::create([
                'contract_number' => $contractNumber,
                'client_id' => $this->client_id,
                'motorcycle_id' => $this->motorcycle_id,
                'motorcycle_value' => $this->motorcycle_value,
                'initial_payment' => $this->initial_payment,
                'financed_amount' => $this->financed_amount,
                'term_months' => $this->term_months,
                'monthly_rate' => $this->monthly_rate,
                'monthly_payment' => $this->monthly_payment,
                'payment_day' => $this->payment_day,
                'start_date' => $this->start_date,
                'end_date' => $endDate,
                'status' => 'activo',
                'signed_contract_path' => $contractPath,
                'contract_signed_at' => now(),
                'notes' => $this->notes,
                'created_by' => auth()->id(),
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            $paymentSchedule = $calculator->generatePaymentSchedule(
                $this->financed_amount,
                $this->monthly_rate,
                $this->term_months,
                Carbon::parse($this->start_date),
                $this->payment_day
            );

            foreach ($paymentSchedule as $payment) {
                $contract->payments()->create($payment);
            }

            Motorcycle::find($this->motorcycle_id)->update(['status' => 'sold']);
        });

        session()->flash('message', 'Contrato creado exitosamente');
        $client = Client::find($this->client_id);
        return redirect()->route('clients.show', $client);
    }

    public function render()
    {
        $clients = Client::where('status', 'aprobado')->orderBy('first_name')->get();
        $motorcycles = Motorcycle::where('status', 'active')->orderBy('brand')->get();

        return view('livewire.leasing.contract-form', [
            'clients' => $clients,
            'motorcycles' => $motorcycles
        ]);
    }
}
