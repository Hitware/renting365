<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\Client;

class ClientView extends Component
{
    public Client $client;
    public $activeTab = 'personal';

    protected $listeners = ['documentUploaded' => '$refresh'];

    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $this->client->load([
            'contacts',
            'currentEmployment',
            'latestFinancial',
            'references',
            'documents' => function($query) {
                $query->where('is_current_version', true);
            },
            'credits',
            'latestMidatacredito',
            'leasingContracts' => function($query) {
                $query->with('motorcycle')->orderBy('created_at', 'desc');
            }
        ]);

        return view('livewire.clients.client-view');
    }
}
