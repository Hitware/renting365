<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Contrato {{ $contract->contract_number }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Información del Contrato -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $contract->client ? $contract->client->full_name : 'Cliente no encontrado' }}</h3>
                    <p class="text-gray-600">{{ $contract->motorcycle ? $contract->motorcycle->brand . ' ' . $contract->motorcycle->model . ' - ' . $contract->motorcycle->plate : 'Motocicleta no encontrada' }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $contract->status_badge_color }}">
                    {{ ucfirst($contract->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-blue-50 rounded-lg p-4">
                    <p class="text-sm text-blue-600">Cuota Mensual</p>
                    <p class="text-2xl font-bold text-blue-900">${{ number_format($contract->monthly_payment, 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <p class="text-sm text-green-600">Monto Financiado</p>
                    <p class="text-2xl font-bold text-green-900">${{ number_format($contract->financed_amount, 0, ',', '.') }}</p>
                </div>
                <div class="bg-orange-50 rounded-lg p-4">
                    <p class="text-sm text-orange-600">Plazo</p>
                    <p class="text-2xl font-bold text-orange-900">{{ $contract->term_months }} meses</p>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <p class="text-sm text-purple-600">Pagos Realizados</p>
                    <p class="text-2xl font-bold text-purple-900">{{ $contract->paid_payments_count }}/{{ $contract->term_months }}</p>
                </div>
            </div>

            <div class="flex space-x-3">
                @if($contract->signed_contract_path)
                <a href="{{ route('leasing.contract.view', $contract) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Ver Contrato Firmado
                </a>
                @endif
                <a href="{{ route('leasing.print.schedule', $contract) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimir Proyección
                </a>
                <a href="{{ route('leasing.print.contract', $contract) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Imprimir Contrato
                </a>
            </div>
        </div>

        <!-- Proyección de Pagos -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Proyección de Pagos</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Fecha Vencimiento</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Cuota</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Capital</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Interés</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500">Saldo</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($contract->payments as $payment)
                        <tr class="{{ $payment->status === 'pagado' ? 'bg-green-50' : '' }}">
                            <td class="px-4 py-2 text-sm">{{ $payment->payment_number }}</td>
                            <td class="px-4 py-2 text-sm">{{ $payment->due_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm text-right">${{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm text-right">${{ number_format($payment->principal, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm text-right">${{ number_format($payment->interest, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-sm text-right font-medium">${{ number_format($payment->balance, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $payment->status_badge_color }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mantenimientos -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Mantenimientos Programados</h3>
                <button class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition">
                    Programar Mantenimiento
                </button>
            </div>
            <div class="space-y-4">
                @forelse($contract->maintenances as $maintenance)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-medium text-gray-900">{{ ucfirst($maintenance->maintenance_type) }}</h4>
                            <p class="text-sm text-gray-600">{{ $maintenance->description }}</p>
                            <p class="text-sm text-gray-500 mt-1">Programado: {{ $maintenance->scheduled_date->format('d/m/Y') }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $maintenance->status_badge_color }}">
                            {{ ucfirst($maintenance->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-8">No hay mantenimientos programados</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
