<?php

namespace App\Http\Controllers;

use App\Models\ClientDocument;
use Illuminate\Support\Facades\Storage;

class ClientDocumentController extends Controller
{
    public function view(ClientDocument $document)
    {
        $this->authorize('clients.view');

        $path = Storage::disk('private')->path($document->file_path);
        $mimeType = $document->mime_type;

        return response()->file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"'
        ]);
    }
}
