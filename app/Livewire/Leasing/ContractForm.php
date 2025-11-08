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
    
    // Campos de la moto
    public $brand = '';
    public $model = '';
    public $year;
    public $plate = '';
    public $motor_number = '';
    public $chassis_number = '';
    public $color = '';
    public $displacement = 100;
    
    // Campos del contrato
    public $motorcycle_value;
    public $initial_payment = 0;
    public $term_months = 12;
    public $payment_frequency = 'mensual';
    public $payment_day = 5;
    public $start_date;
    public $signed_contract;
    public $notes;

    public $financed_amount;
    public $monthly_payment;
    public $total_interest;
    public $payment_schedule = [];
    public $showPreview = false;

    protected function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:2030',
            'plate' => [
                'required',
                'string',
                'min:1',
                'max:10',
                \Illuminate\Validation\Rule::unique('motorcycles', 'plate')->ignore($this->motorcycle_id)
            ],
            'motor_number' => 'required|string|min:1|max:50',
            'chassis_number' => 'required|string|min:1|max:50',
            'color' => 'required|string|max:50',
            'displacement' => 'required|integer|min:50|max:1000',
            'motorcycle_value' => 'required|numeric|min:0',
            'initial_payment' => 'required|numeric|min:0',
            'term_months' => 'required|integer|min:1|max:365',
            'payment_frequency' => 'required|in:diaria,semanal,quincenal,mensual',
            'payment_day' => 'required|integer|min:1|max:28',
            'start_date' => 'required|date|after_or_equal:today',
            'signed_contract' => 'required|file|mimes:pdf|max:10240'
        ];
    }
    
    protected $messages = [
        'plate.required' => 'La placa es obligatoria',
        'plate.min' => 'La placa no puede estar vacía',
        'motor_number.required' => 'El número de motor es obligatorio',
        'motor_number.min' => 'El número de motor no puede estar vacío',
        'chassis_number.required' => 'El número de chasis es obligatorio',
        'chassis_number.min' => 'El número de chasis no puede estar vacío'
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
            if ($motorcycle) {
                $this->brand = $motorcycle->brand;
                $this->model = $motorcycle->model;
                $this->year = $motorcycle->year;
                $this->plate = $motorcycle->plate;
                $this->motor_number = $motorcycle->motor_number;
                $this->chassis_number = $motorcycle->chassis_number;
                $this->color = $motorcycle->color;
                $this->displacement = $motorcycle->displacement;
                $this->motorcycle_value = $motorcycle->purchase_price ?? 0;
            }
        }
    }
    
    public function updatedPlate($value)
    {
        if ($value) {
            $exists = Motorcycle::where('plate', $value)
                ->when($this->motorcycle_id, function($query) {
                    return $query->where('id', '!=', $this->motorcycle_id);
                })
                ->exists();
            
            if ($exists) {
                $this->addError('plate', 'Esta placa ya está registrada en el sistema');
                return;
            }
        }
        $this->validateOnly('plate');
    }
    
    public function updatedMotorNumber($value)
    {
        $this->validateOnly('motor_number');
    }
    
    public function updatedChassisNumber($value)
    {
        $this->validateOnly('chassis_number');
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

    public function calculateFinancing()
    {
        if ($this->motorcycle_value && $this->initial_payment >= 0 && $this->term_months > 0) {
            $this->financed_amount = $this->motorcycle_value - $this->initial_payment;
            $this->monthly_payment = round($this->financed_amount / $this->term_months, 2);
        }
    }

    public function generatePreview()
    {
        $this->validate([
            'motorcycle_value' => 'required|numeric|min:0',
            'initial_payment' => 'required|numeric|min:0',
            'term_months' => 'required|integer|min:1|max:365',
            'payment_day' => 'required|integer|min:1|max:28',
            'start_date' => 'required|date'
        ]);

        $this->payment_schedule = $this->generateSimplePaymentSchedule();
        $this->showPreview = true;
    }

    private function generateSimplePaymentSchedule()
    {
        $schedule = [];
        $balance = $this->financed_amount;
        $regularPayment = $this->monthly_payment;

        for ($i = 1; $i <= $this->term_months; $i++) {
            $dueDate = $this->calculateNextPaymentDate($i);
            
            // Última cuota ajusta cualquier diferencia por redondeo
            if ($i == $this->term_months) {
                $payment = $balance;
            } else {
                $payment = $regularPayment;
            }
            
            $balance -= $payment;

            $schedule[] = [
                'payment_number' => $i,
                'due_date' => $dueDate,
                'amount' => $payment,
                'principal' => $payment,
                'interest' => 0,
                'balance' => max(0, $balance)
            ];
        }

        return $schedule;
    }

    private function calculateNextPaymentDate($paymentNumber)
    {
        $startDate = Carbon::parse($this->start_date);
        
        switch ($this->payment_frequency) {
            case 'diaria':
                return $startDate->addDays($paymentNumber - 1);
            case 'semanal':
                return $startDate->addWeeks($paymentNumber - 1);
            case 'quincenal':
                return $startDate->addWeeks(($paymentNumber - 1) * 2);
            case 'mensual':
            default:
                return $startDate->addMonths($paymentNumber - 1)->day($this->payment_day);
        }
    }

    public function save()
    {
        // Limpiar strings vacíos
        $this->plate = trim($this->plate) ?: null;
        $this->motor_number = trim($this->motor_number) ?: null;
        $this->chassis_number = trim($this->chassis_number) ?: null;
        
        $this->validate();

        DB::transaction(function () {
            // Crear o usar moto existente
            if ($this->motorcycle_id) {
                $motorcycle = Motorcycle::find($this->motorcycle_id);
                $motorcycle->update([
                    'brand' => $this->brand,
                    'model' => $this->model,
                    'year' => (int)$this->year,
                    'plate' => $this->plate,
                    'motor_number' => $this->motor_number,
                    'chassis_number' => $this->chassis_number,
                    'color' => $this->color,
                    'displacement' => (int)$this->displacement,
                    'purchase_price' => $this->motorcycle_value,
                    'status' => 'sold',
                    'updated_by' => auth()->id()
                ]);
            } else {
                $motorcycle = Motorcycle::create([
                    'brand' => $this->brand,
                    'model' => $this->model,
                    'year' => (int)$this->year,
                    'plate' => $this->plate,
                    'motor_number' => $this->motor_number,
                    'chassis_number' => $this->chassis_number,
                    'color' => $this->color,
                    'displacement' => (int)$this->displacement,
                    'purchase_price' => $this->motorcycle_value,
                    'purchase_date' => now(),
                    'status' => 'sold',
                    'created_by' => auth()->id()
                ]);
            }
            
            $contractNumber = 'LC-' . now()->format('Ymd') . '-' . str_pad(LeasingContract::count() + 1, 4, '0', STR_PAD_LEFT);
            
            $contractPath = $this->signed_contract->store('leasing_contracts', 'private');

            $endDate = Carbon::parse($this->start_date)->addMonths($this->term_months);

            $contract = LeasingContract::create([
                'contract_number' => $contractNumber,
                'client_id' => $this->client_id,
                'motorcycle_id' => $motorcycle->id,
                'motorcycle_value' => $this->motorcycle_value,
                'initial_payment' => $this->initial_payment,
                'financed_amount' => $this->financed_amount,
                'term_months' => $this->term_months,
                'monthly_rate' => 0,
                'monthly_payment' => $this->monthly_payment,
                'payment_frequency' => $this->payment_frequency,
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

            $paymentSchedule = $this->generateSimplePaymentSchedule();

            foreach ($paymentSchedule as $payment) {
                $contract->payments()->create($payment);
            }
        });

        session()->flash('message', 'Contrato y moto registrados exitosamente');
        $client = Client::find($this->client_id);
        return redirect()->route('clients.show', $client);
    }

    public function render()
    {
        $clients = Client::whereIn('status', ['registro_inicial', 'en_estudio', 'aprobado'])->orderBy('first_name')->get();
        $motorcycles = Motorcycle::where('status', 'active')->orderBy('brand')->get();

        return view('livewire.leasing.contract-form', [
            'clients' => $clients,
            'motorcycles' => $motorcycles
        ]);
    }
}
