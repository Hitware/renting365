<?php

namespace App\Livewire\Clients;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Client;
use App\Models\ClientDocument;
use Illuminate\Support\Facades\Storage;

class DocumentUpload extends Component
{
    use WithFileUploads;

    public Client $client;
    public $document;
    public $document_type;
    public $uploading = false;

    protected $listeners = ['documentReviewed' => '$refresh'];

    protected $rules = [
        'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'document_type' => 'required|in:cedula_frontal,cedula_reverso,certificado_laboral,desprendible_pago,extracto_bancario,servicio_publico,referencia_firmada,contrato,otro'
    ];

    protected $messages = [
        'document.required' => 'Debe seleccionar un archivo',
        'document.mimes' => 'Solo se permiten archivos PDF, JPG, JPEG o PNG',
        'document.max' => 'El archivo no debe superar 5MB',
        'document_type.required' => 'Debe seleccionar el tipo de documento'
    ];

    public function uploadDocument()
    {
        $this->validate();
        $this->uploading = true;

        try {
            $path = $this->document->store('client_documents', 'private');

            $currentVersion = ClientDocument::where('client_id', $this->client->id)
                ->where('document_type', $this->document_type)
                ->max('version') ?? 0;

            ClientDocument::where('client_id', $this->client->id)
                ->where('document_type', $this->document_type)
                ->update(['is_current_version' => false]);

            ClientDocument::create([
                'client_id' => $this->client->id,
                'document_type' => $this->document_type,
                'file_name' => $this->document->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $this->document->getSize(),
                'mime_type' => $this->document->getMimeType(),
                'version' => $currentVersion + 1,
                'upload_date' => now(),
                'status' => 'pendiente',
                'is_current_version' => true,
                'uploaded_by' => auth()->id()
            ]);

            $this->dispatch('documentUploaded');
            session()->flash('message', 'Documento cargado exitosamente');
            $this->reset(['document', 'document_type']);

        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar documento: ' . $e->getMessage());
        } finally {
            $this->uploading = false;
        }
    }

    public function render()
    {
        $requiredDocuments = [
            'cedula_frontal' => 'Cédula - Frontal',
            'cedula_reverso' => 'Cédula - Reverso',
            'certificado_laboral' => 'Certificado Laboral',
            'desprendible_pago' => 'Desprendible de Pago',
            'extracto_bancario' => 'Extracto Bancario',
            'servicio_publico' => 'Recibo Servicio Público'
        ];

        $uploadedDocuments = $this->client->documents()
            ->where('is_current_version', true)
            ->get()
            ->keyBy('document_type');

        return view('livewire.clients.document-upload', [
            'requiredDocuments' => $requiredDocuments,
            'uploadedDocuments' => $uploadedDocuments
        ]);
    }
}
