<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <svg class="w-7 h-7 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Registrar Pago
        </h2>

        <!-- Buscador -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Contrato</label>
            <div class="relative">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Buscar por nombre, cédula o número de contrato..."
                    class="w-full px-4 py-3 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>

        <!-- Resultados de búsqueda -->
        @if(count($searchResults) > 0)
        <div class="border border-gray-200 rounded-lg mb-6 max-h-96 overflow-y-auto">
            <div class="divide-y divide-gray-200">
                @foreach($searchResults as $result)
                <div wire:click="selectContract({{ $result['id'] }})"
                     class="p-4 hover:bg-orange-50 cursor-pointer transition-colors">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="text-sm font-medium text-gray-900">{{ $result['contract_number'] }}</span>
                                @if($result['has_overdue'])
                                <span class="px-2 py-0.5 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                    En Mora
                                </span>
                                @endif
                            </div>
                            <p class="text-sm font-semibold text-gray-700">{{ $result['client_name'] }}</p>
                            <p class="text-xs text-gray-500">CC: {{ $result['client_document'] }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $result['motorcycle'] }}</p>

                            @if($result['next_payment'])
                            <div class="mt-2 flex items-center text-xs text-gray-600">
                                <span class="font-medium">Cuota #{{ $result['next_payment']->payment_number }}:</span>
                                <span class="ml-2">${{ number_format($result['next_payment']->amount, 0, ',', '.') }}</span>
                                <span class="ml-2">•</span>
                                <span class="ml-2">Vence: {{ $result['next_payment']->due_date->format('d/m/Y') }}</span>
                            </div>
                            @endif
                        </div>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @elseif(strlen($search) >= 3)
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            No se encontraron contratos
        </div>
        @endif

        <!-- Información inicial -->
        @if(strlen($search) < 3 && count($searchResults) == 0)
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <p class="text-gray-500 text-sm">Ingresa al menos 3 caracteres para buscar</p>
        </div>
        @endif
    </div>

    <!-- Modal de Registro de Pago -->
    @if($showModal && $selectedPayment)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Registrar Pago</h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Información del Contrato -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Cliente</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $selectedContract->client->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Contrato</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $selectedContract->contract_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Motocicleta</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $selectedContract->motorcycle->brand }} {{ $selectedContract->motorcycle->model }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Placa</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $selectedContract->motorcycle->plate }}</p>
                    </div>
                </div>
            </div>

            <!-- Detalle del Pago -->
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                <h4 class="text-sm font-semibold text-gray-900 mb-3">Detalles de la Cuota</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-600">Cuota a Pagar</p>
                        <p class="text-lg font-bold text-orange-600">#{{ $selectedPayment->payment_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Monto de Cuota</p>
                        <p class="text-lg font-bold text-gray-900">${{ number_format($selectedPayment->amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Fecha de Vencimiento</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $selectedPayment->due_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Estado</p>
                        @if($selectedPayment->status == 'atrasado')
                        <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                            Con Mora
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                            A tiempo
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Formulario de Pago -->
            <form wire:submit.prevent="registerPayment" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Monto Recibido *</label>
                        <input type="number" wire:model="amount_received" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('amount_received') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Pago *</label>
                        <input type="date" wire:model="payment_date"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('payment_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Método de Pago *</label>
                        <select wire:model="payment_method"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <option value="efectivo">Efectivo</option>
                            <option value="transferencia">Transferencia</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="cheque">Cheque</option>
                            <option value="pse">PSE</option>
                        </select>
                        @error('payment_method') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Recibo/Referencia</label>
                        <input type="text" wire:model="reference_number"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                               placeholder="Opcional">
                        @error('reference_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                    <textarea wire:model="notes" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                              placeholder="Notas adicionales (opcional)"></textarea>
                    @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" wire:click="closeModal"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition">
                        Registrar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Modal de Éxito -->
    @if($showSuccess)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Pago Registrado</h3>
                <p class="text-gray-600 mb-6">El pago se ha registrado exitosamente</p>
                <button wire:click="closeSuccess"
                        class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
