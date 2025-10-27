<div class="space-y-6">
    <h3 class="text-lg font-bold text-gray-900">Documentos</h3>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Lista de documentos requeridos -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($requiredDocuments as $type => $label)
        <div class="border border-gray-200 rounded-lg p-4 {{ isset($uploadedDocuments[$type]) ? 'bg-green-50 border-green-300' : 'bg-white' }}">
            <div class="flex items-center justify-between mb-2">
                <h4 class="font-medium text-gray-900">{{ $label }}</h4>
                @if(isset($uploadedDocuments[$type]))
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $uploadedDocuments[$type]->status === 'aprobado' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $uploadedDocuments[$type]->status === 'rechazado' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $uploadedDocuments[$type]->status === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                        {{ ucfirst($uploadedDocuments[$type]->status) }}
                    </span>
                @else
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                        Pendiente
                    </span>
                @endif
            </div>

            @if(isset($uploadedDocuments[$type]))
                <div class="text-sm text-gray-600 mb-2">
                    <p>{{ $uploadedDocuments[$type]->file_name }}</p>
                    <p class="text-xs">Subido: {{ $uploadedDocuments[$type]->upload_date->format('d/m/Y H:i') }}</p>
                    @if($uploadedDocuments[$type]->review_comments)
                        <p class="text-xs text-gray-500 mt-1">{{ $uploadedDocuments[$type]->review_comments }}</p>
                    @endif
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('client.document.view', $uploadedDocuments[$type]->id) }}" target="_blank" 
                       class="text-sm text-green-600 hover:text-green-800">
                        Ver
                    </a>
                    @can('clients.edit')
                    <button wire:click="$dispatch('openReviewModal', { documentId: {{ $uploadedDocuments[$type]->id }} })" 
                            class="text-sm text-blue-600 hover:text-blue-800">
                        Revisar
                    </button>
                    @endcan
                    <button wire:click="$set('document_type', '{{ $type }}')" class="text-sm text-orange-600 hover:text-orange-800">
                        Reemplazar
                    </button>
                </div>
            @else
                <button wire:click="$set('document_type', '{{ $type }}')" class="text-sm text-orange-600 hover:text-orange-800">
                    Cargar documento
                </button>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Modal de revisión -->
    <livewire:clients.document-review />

    <!-- Formulario de carga -->
    @if($document_type)
    <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
        <h4 class="font-medium text-gray-900 mb-4">Cargar: {{ $requiredDocuments[$document_type] ?? 'Documento' }}</h4>
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Seleccionar archivo (PDF, JPG, PNG - Máx 5MB)</label>
                <input type="file" wire:model="document" accept=".pdf,.jpg,.jpeg,.png" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                @error('document') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            @if($document)
                <div class="text-sm text-gray-600">
                    Archivo seleccionado: {{ $document->getClientOriginalName() }}
                </div>
            @endif

            <div class="flex space-x-3">
                <button type="button" wire:click="uploadDocument" 
                        wire:loading.attr="disabled"
                        class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors disabled:opacity-50">
                    <span wire:loading.remove wire:target="uploadDocument">Subir Documento</span>
                    <span wire:loading wire:target="uploadDocument">Subiendo...</span>
                </button>
                <button type="button" wire:click="$set('document_type', null)" 
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Indicador de progreso -->
    <div wire:loading wire:target="document" class="text-center py-4">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-orange-600"></div>
        <p class="text-sm text-gray-600 mt-2">Cargando archivo...</p>
    </div>
</div>
