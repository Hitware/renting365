<?php

namespace App\Livewire\Maintenance;

use Livewire\Component;
use App\Models\MotorcycleMaintenance;
use App\Models\LeasingContract;
use App\Models\Motorcycle;
use Carbon\Carbon;

class ScheduleMaintenance extends Component
{
    public $contractId;
    public $motorcycleId;
    public $type = 'preventive';
    public $title;
    public $description;
    public $scheduled_date;
    public $workshop_name;
    public $estimated_cost;
    public $notes;
    public $showModal = false;

    protected $rules = [
        'motorcycleId' => 'required|exists:motorcycles,id',
        'type' => 'required|in:preventive,corrective,inspection,other',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'scheduled_date' => 'required|date|after_or_equal:today',
        'workshop_name' => 'nullable|string|max:255',
        'estimated_cost' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string'
    ];

    protected $listeners = ['openScheduleModal'];

    public function mount($contractId = null)
    {
        $this->contractId = $contractId;
        if ($contractId) {
            $contract = LeasingContract::find($contractId);
            if ($contract) {
                $this->motorcycleId = $contract->motorcycle_id;
            }
        }
        $this->scheduled_date = now()->addDays(7)->format('Y-m-d');
    }

    public function openScheduleModal($contractId = null)
    {
        if ($contractId) {
            $contract = LeasingContract::find($contractId);
            if ($contract) {
                $this->motorcycleId = $contract->motorcycle_id;
            }
        }
        $this->showModal = true;
    }

    public function schedule()
    {
        $this->validate();

        MotorcycleMaintenance::create([
            'motorcycle_id' => $this->motorcycleId,
            'leasing_contract_id' => $this->contractId,
            'type' => $this->type,
            'title' => $this->title,
            'description' => $this->description,
            'scheduled_date' => $this->scheduled_date,
            'status' => 'pending',
            'workshop_name' => $this->workshop_name,
            'estimated_cost' => $this->estimated_cost,
            'notes' => $this->notes,
            'registered_by' => auth()->id()
        ]);

        session()->flash('message', 'Mantenimiento programado exitosamente');
        $this->reset(['type', 'title', 'description', 'workshop_name', 'estimated_cost', 'notes']);
        $this->scheduled_date = now()->addDays(7)->format('Y-m-d');
        $this->showModal = false;
        $this->dispatch('maintenanceScheduled');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        $motorcycles = Motorcycle::whereIn('status', ['active', 'sold'])->get();
        return view('livewire.maintenance.schedule-maintenance', compact('motorcycles'));
    }
}
