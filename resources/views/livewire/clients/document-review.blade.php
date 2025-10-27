<div>
    @if($showModal && $document)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

            <!-- Modal -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <!-- Header -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">
                            Revisión de Documento
                        </h3>
                        <button wire:click="closeModal" class="text-white hover:text-gray-200">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Body -->
                <div class="px-6 py-4">
                    <!-- Información del documento -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Cliente:</span>
                                <span class="font-medium text-gray-900">{{ $document->client->full_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Tipo:</span>
                                <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $document->document_type)) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Cargado:</span>
                                <span class="font-medium text-gray-900">{{ $document->upload_date->format('d/m/Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Archivo:</span>
                                <span class="font-medium text-gray-900">{{ $document->file_name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Tamaño:</span>
                                <span class="font-medium text-gray-900">{{ number_format($document->file_size / 1024, 2) }} KB</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Versión:</span>
                                <span class="font-medium text-gray-900">{{ $document->version }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Vista previa del documento -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm font-medium text-gray-700">Vista Previa del Documento</h4>
                            <button wire:click="downloadDocument" class="px-3 py-1 text-sm bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                <svg class="inline-block w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Descargar
                            </button>
                        </div>
                        <div class="border-2 border-gray-300 rounded-lg overflow-hidden bg-gray-50">
                            @if(in_array($document->mime_type, ['application/pdf']))
                                <iframe src="{{ route('client.document.view', $document->id) }}" class="w-full" style="height: 600px;"></iframe>
                            @elseif(in_array($document->mime_type, ['image/jpeg', 'image/jpg', 'image/png']))
                                <img src="{{ route('client.document.view', $document->id) }}" alt="{{ $document->file_name }}" class="w-full h-auto">
                            @else
                                <div class="p-8 text-center">
                                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-600">Vista previa no disponible para este tipo de archivo</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Formulario de revisión -->
                    <form wire:submit.prevent="submitReview" class="space-y-6">
                        <!-- Decisión -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Decisión *</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                    {{ $decision === 'aprobar' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300' }}">
                                    <input type="radio" wire:model="decision" value="aprobar" class="sr-only">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 {{ $decision === 'aprobar' ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium {{ $decision === 'aprobar' ? 'text-green-900' : 'text-gray-900' }}">Aprobar</p>
                                            <p class="text-xs {{ $decision === 'aprobar' ? 'text-green-700' : 'text-gray-500' }}">Documento válido</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                    {{ $decision === 'rechazar' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-red-300' }}">
                                    <input type="radio" wire:model="decision" value="rechazar" class="sr-only">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 {{ $decision === 'rechazar' ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium {{ $decision === 'rechazar' ? 'text-red-900' : 'text-gray-900' }}">Rechazar</p>
                                            <p class="text-xs {{ $decision === 'rechazar' ? 'text-red-700' : 'text-gray-500' }}">No cumple requisitos</p>
                                        </div>
                                    </div>
                                </label>

                                <label class="relative flex items-center p-4 border-2 rounded-lg cursor-pointer transition-all
                                    {{ $decision === 'solicitar_nueva' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-yellow-300' }}">
                                    <input type="radio" wire:model="decision" value="solicitar_nueva" class="sr-only">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 {{ $decision === 'solicitar_nueva' ? 'text-yellow-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium {{ $decision === 'solicitar_nueva' ? 'text-yellow-900' : 'text-gray-900' }}">Solicitar Nueva</p>
                                            <p class="text-xs {{ $decision === 'solicitar_nueva' ? 'text-yellow-700' : 'text-gray-500' }}">Requiere corrección</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('decision') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Comentarios -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Comentarios {{ in_array($decision, ['rechazar', 'solicitar_nueva']) ? '*' : '' }}
                            </label>
                            <textarea wire:model="reviewComments" rows="4" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                                      placeholder="Ingrese sus observaciones sobre el documento..."></textarea>
                            @error('reviewComments') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                            <button type="button" wire:click="closeModal" 
                                    class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                                Cancelar
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors">
                                Guardar Revisión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
