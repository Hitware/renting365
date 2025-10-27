<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Crear Contrato de Leasing</h2>

        @if (session()->has('message'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <!-- Cliente y Moto -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cliente *</label>
                    <select wire:model="client_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500" {{ $client_id ? 'disabled' : '' }}>
                        <option value="">Seleccionar cliente</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->full_name }} - {{ $client->document_number }}</option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Motocicleta *</label>
                    <select wire:model.live="motorcycle_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        <option value="">Seleccionar moto</option>
                        @foreach($motorcycles as $motorcycle)
                            <option value="{{ $motorcycle->id }}">{{ $motorcycle->brand }} {{ $motorcycle->model }} - {{ $motorcycle->plate }}</option>
                        @endforeach
                    </select>
                    @error('motorcycle_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Valores -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Valor Moto *</label>
                    <input type="number" wire:model.live="motorcycle_value" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    @error('motorcycle_value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cuota Inicial</label>
                    <input type="number" wire:model.live="initial_payment" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    @error('initial_payment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Monto Financiado</label>
                    <input type="text" value="${{ number_format($financed_amount ?? 0, 0, ',', '.') }}" disabled class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                </div>
            </div>

            <!-- Términos -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Plazo (meses) *</label>
                    <input type="number" wire:model.live="term_months" min="6" max="60" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    @error('term_months') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tasa Mensual (%) *</label>
                    <input type="number" wire:model.live="monthly_rate" step="0.01" min="0" max="10" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    @error('monthly_rate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Día de Pago *</label>
                    <input type="number" wire:model="payment_day" min="1" max="28" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    @error('payment_day') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fecha Inicio *</label>
                    <input type="date" wire:model="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Resumen -->
            @if($monthly_payment)
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Resumen del Financiamiento</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Cuota Mensual</p>
                        <p class="text-2xl font-bold text-orange-600">${{ number_format($monthly_payment, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Intereses</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format($total_interest ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total a Pagar</p>
                        <p class="text-2xl font-bold text-gray-900">${{ number_format(($monthly_payment * $term_months), 0, ',', '.') }}</p>
                    </div>
                </div>
                <button type="button" wire:click="generatePreview" class="mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    Ver Proyección de Pagos
                </button>
            </div>
            @endif

            <!-- Proyección de Pagos -->
            @if($showPreview && count($payment_schedule) > 0)
            <div class="border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Proyección de Pagos</h3>
                <div class="overflow-x-auto max-h-96">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">#</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Fecha</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Cuota</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Capital</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Interés</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Saldo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($payment_schedule as $payment)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ $payment['payment_number'] }}</td>
                                <td class="px-4 py-2 text-sm">{{ $payment['due_date']->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-sm text-right">${{ number_format($payment['amount'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-right">${{ number_format($payment['principal'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-right">${{ number_format($payment['interest'], 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-sm text-right font-medium">${{ number_format($payment['balance'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Contrato Firmado -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contrato Firmado (PDF) *</label>
                <input type="file" wire:model="signed_contract" accept=".pdf" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                @error('signed_contract') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <div wire:loading wire:target="signed_contract" class="text-sm text-gray-600 mt-2">Cargando archivo...</div>
            </div>

            <!-- Notas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                <textarea wire:model="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"></textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('clients.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition">
                    Crear Contrato
                </button>
            </div>
        </form>
    </div>
</div>
