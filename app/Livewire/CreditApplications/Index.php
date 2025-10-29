<?php

namespace App\Livewire\CreditApplications;

use App\Models\CreditApplication;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $cityFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    
    public $selectedApplication;
    public $newStatus;
    public $newAdvisor;
    public $newObservations;
    public $showEditModal = false;

    protected $queryString = ['search', 'statusFilter', 'cityFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->selectedApplication = CreditApplication::findOrFail($id);
        $this->newStatus = $this->selectedApplication->status;
        $this->newAdvisor = $this->selectedApplication->assigned_advisor_id;
        $this->newObservations = $this->selectedApplication->observations;
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->selectedApplication->update([
            'status' => $this->newStatus,
            'assigned_advisor_id' => $this->newAdvisor,
            'observations' => $this->newObservations,
        ]);

        $this->showEditModal = false;
        session()->flash('message', 'Solicitud actualizada correctamente');
    }

    public function render()
    {
        $query = CreditApplication::with('assignedAdvisor');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                  ->orWhere('document_number', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->cityFilter) {
            $query->where('city', $this->cityFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('created_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('created_at', '<=', $this->dateTo);
        }

        $applications = $query->latest()->paginate(15);
        
        $stats = [
            'total' => CreditApplication::count(),
            'pending' => CreditApplication::where('status', 'pending')->count(),
            'in_study' => CreditApplication::where('status', 'in_study')->count(),
            'approved' => CreditApplication::where('status', 'approved')->count(),
            'rejected' => CreditApplication::where('status', 'rejected')->count(),
        ];

        $advisors = User::whereHas('roles', function($q) {
            $q->where('slug', 'asesor');
        })->get();

        return view('livewire.credit-applications.index', [
            'applications' => $applications,
            'stats' => $stats,
            'advisors' => $advisors,
        ]);
    }
}
