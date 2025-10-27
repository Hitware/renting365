<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use App\Models\User;

class ClientList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $analystFilter = '';
    public $scoreFilter = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'page' => ['except' => 1]
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->analystFilter = '';
        $this->scoreFilter = '';
        $this->resetPage();
    }

    public function render()
    {
        $clients = Client::query()
            ->with(['assignedAnalyst', 'currentEmployment', 'primaryContact'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('document_number', 'like', '%' . $this->search . '%')
                      ->orWhere('full_name', 'like', '%' . $this->search . '%')
                      ->orWhere('first_name', 'like', '%' . $this->search . '%')
                      ->orWhere('last_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->analystFilter, function ($query) {
                $query->where('assigned_analyst_id', $this->analystFilter);
            })
            ->when($this->scoreFilter, function ($query) {
                switch ($this->scoreFilter) {
                    case 'excelente':
                        $query->where('credit_score', '>=', 750);
                        break;
                    case 'bueno':
                        $query->whereBetween('credit_score', [650, 749]);
                        break;
                    case 'regular':
                        $query->whereBetween('credit_score', [550, 649]);
                        break;
                    case 'malo':
                        $query->where('credit_score', '<', 550);
                        break;
                }
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(20);

        $analysts = User::whereHas('roles', function($q) {
            $q->whereIn('slug', ['analista_credito', 'gerente_credito']);
        })->get();

        $stats = [
            'total' => Client::count(),
            'pending' => Client::whereIn('status', ['registro_inicial', 'documentacion_pendiente', 'en_revision'])->count(),
            'approved' => Client::where('status', 'aprobado')->count(),
            'rejected' => Client::where('status', 'rechazado')->count(),
        ];

        return view('livewire.clients.client-list', [
            'clients' => $clients,
            'analysts' => $analysts,
            'stats' => $stats
        ]);
    }
}
