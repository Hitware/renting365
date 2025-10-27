<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use App\Models\ClientDocument;
use Illuminate\Support\Facades\Storage;

class DocumentReview extends Component
{
    public $document;
    public $showModal = false;
    public $decision;
    public $reviewComments;

    protected $listeners = ['openReviewModal'];

    protected $rules = [
        'decision' => 'required|in:aprobar,rechazar,solicitar_nueva',
        'reviewComments' => 'required_if:decision,rechazar,solicitar_nueva|string|max:500'
    ];

    protected $messages = [
        'decision.required' => 'Debe seleccionar una decisión',
        'reviewComments.required_if' => 'Los comentarios son obligatorios para rechazar o solicitar nueva versión'
    ];

    public function openReviewModal($documentId)
    {
        $this->document = ClientDocument::with('client')->findOrFail($documentId);
        $this->showModal = true;
        $this->reset(['decision', 'reviewComments']);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['decision', 'reviewComments']);
    }

    public function submitReview()
    {
        $this->validate();

        $status = match($this->decision) {
            'aprobar' => 'aprobado',
            'rechazar' => 'rechazado',
            'solicitar_nueva' => 'pendiente'
        };

        $this->document->update([
            'status' => $status,
            'reviewed_by' => auth()->id(),
            'review_date' => now(),
            'review_comments' => $this->reviewComments
        ]);

        $this->document->client->notes()->create([
            'note_type' => 'seguimiento',
            'note_content' => "Documento {$this->document->document_type} {$status}. " . $this->reviewComments,
            'created_by' => auth()->id()
        ]);

        $this->dispatch('documentReviewed')->to('clients.document-upload');
        session()->flash('message', 'Revisión guardada exitosamente');
        $this->closeModal();
    }

    public function downloadDocument()
    {
        if (!$this->document) return;

        return Storage::disk('private')->download(
            $this->document->file_path,
            $this->document->file_name
        );
    }

    public function getDocumentUrl()
    {
        if (!$this->document) return null;
        
        return route('client.document.view', ['document' => $this->document->id]);
    }

    public function render()
    {
        return view('livewire.clients.document-review');
    }
}
