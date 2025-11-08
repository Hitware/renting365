<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-lg font-bold text-red-900">⚠️ Pagos Atrasados</h3>
            <p class="text-sm text-red-600">Cuotas vencidas que requieren atención</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-red-50 rounded-lg p-3 border-2 border-red-200">
            <p class="text-xs text-red-600">Total Atrasado</p>
            <p class="text-xl font-bold text-red-900">${{ number_format($totalOverdue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-orange-50 rounded-lg p-3">
            <p class="text-xs text-orange-600">Clientes en Mora</p>
            <p class="text-xl font-bold text-orange-900">{{ $overduePayments->count() }}</p>
        </div>
        <div class="bg-purple-50 rounded-lg p-3">
            <p class="text-xs text-purple-600">Casos Críticos (+30 días)</p>
            <p class="text-xl font-bold text-purple-900">{{ $criticalCount }}</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        @if($overduePayments->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-red-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-red-700">Urgencia</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-red-700">Cliente</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-red-700">Moto</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-red-700">Días Atraso</th>
                    <th class="px-3 py-2 text-right text-xs font-medium text-red-700">Monto Adeudado</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-red-700">Frecuencia</th>
                    <th class="px-3 py-2 text-center text-xs font-medium text-red-700">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($overduePayments as $item)
                <tr class="hover:bg-red-50 {{ $item['priority'] === 'critical' ? 'bg-red-100' : '' }}">
                    <td class="px-3 py-2">
                        @if($item['priority'] === 'critical')
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-600 text-white">🚨 CRÍTICO</span>
                        @elseif($item['priority'] === 'high')
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">🔴 Alto</span>
                        @else
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-800">🟠 Medio</span>
                        @endif
                    </td>
                    <td class="px-3 py-2">
                        <div class="text-sm font-medium text-gray-900">{{ $item['client']->full_name }}</div>
                        <div class="text-xs text-gray-500">
                            📞 {{ $item['client']->phone }}
                        </div>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-700">
                        {{ $item['motorcycle']->brand }} {{ $item['motorcycle']->model }}
                        <div class="text-xs text-gray-500">{{ $item['motorcycle']->plate }}</div>
                    </td>
                    <td class="px-3 py-2">
                        <div class="text-sm font-bold {{ $item['priority'] === 'critical' ? 'text-red-900' : 'text-orange-900' }}">
                            {{ $item['days_overdue'] }} día{{ $item['days_overdue'] != 1 ? 's' : '' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            Venció: {{ $item['payment']->due_date->format('d/m/Y') }}
                        </div>
                    </td>
                    <td class="px-3 py-2 text-right">
                        <div class="text-sm font-bold text-red-900">${{ number_format($item['payment']->amount, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500">Cuota #{{ $item['payment']->payment_number }}</div>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-700">
                        {{ ucfirst($item['contract']->payment_frequency) }}
                    </td>
                    <td class="px-3 py-2 text-center">
                        <div class="flex flex-col gap-1">
                            <button onclick="Livewire.dispatch('openPaymentModal', { contractId: {{ $item['contract']->id }} })" class="text-green-600 hover:text-green-800 text-xs font-medium">
                                💰 Registrar Pago
                            </button>
                            <a href="tel:{{ $item['client']->phone }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">
                                📞 Llamar
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-8">
            <p class="text-gray-500">✅ No hay pagos atrasados</p>
        </div>
        @endif
    </div>
</div>
