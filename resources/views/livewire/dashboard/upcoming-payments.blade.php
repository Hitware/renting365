<div class="bg-white rounded-xl shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <div>
            <h3 class="text-lg font-bold text-gray-900">📅 Pagos Próximos</h3>
            <p class="text-sm text-gray-600">Cuotas que vencen pronto</p>
        </div>
        <div class="flex gap-2">
            <button wire:click="$set('filter', 'today')" class="px-3 py-1 text-sm rounded-lg {{ $filter === 'today' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                Hoy
            </button>
            <button wire:click="$set('filter', 'week')" class="px-3 py-1 text-sm rounded-lg {{ $filter === 'week' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                Esta Semana
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-blue-50 rounded-lg p-3">
            <p class="text-xs text-blue-600">Total a Cobrar</p>
            <p class="text-xl font-bold text-blue-900">${{ number_format($totalAmount, 0, ',', '.') }}</p>
        </div>
        <div class="bg-green-50 rounded-lg p-3">
            <p class="text-xs text-green-600">Pagos Totales</p>
            <p class="text-xl font-bold text-green-900">{{ $upcomingPayments->count() }}</p>
        </div>
        <div class="bg-orange-50 rounded-lg p-3">
            <p class="text-xs text-orange-600">Vencen Hoy</p>
            <p class="text-xl font-bold text-orange-900">{{ $todayCount }}</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        @if($upcomingPayments->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Prioridad</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Cliente</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Moto</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Vencimiento</th>
                    <th class="px-3 py-2 text-right text-xs font-medium text-gray-500">Monto</th>
                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Frecuencia</th>
                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($upcomingPayments as $item)
                <tr class="hover:bg-gray-50 {{ $item['is_today'] ? 'bg-yellow-50' : '' }}">
                    <td class="px-3 py-2">
                        @if($item['priority'] === 'high')
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">🔴 Urgente</span>
                        @elseif($item['priority'] === 'medium')
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-orange-100 text-orange-800">🟠 Pronto</span>
                        @else
                        <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-800">🟢 Normal</span>
                        @endif
                    </td>
                    <td class="px-3 py-2">
                        <div class="text-sm font-medium text-gray-900">{{ $item['client']->full_name }}</div>
                        <div class="text-xs text-gray-500">{{ $item['client']->phone }}</div>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-700">
                        {{ $item['motorcycle']->brand }} {{ $item['motorcycle']->model }}
                        <div class="text-xs text-gray-500">{{ $item['motorcycle']->plate }}</div>
                    </td>
                    <td class="px-3 py-2">
                        <div class="text-sm font-medium text-gray-900">{{ $item['payment']->due_date->format('d/m/Y') }}</div>
                        <div class="text-xs {{ $item['is_today'] ? 'text-orange-600 font-bold' : 'text-gray-500' }}">
                            @if($item['is_today'])
                            ⏰ Vence HOY
                            @else
                            En {{ abs($item['days_until']) }} día{{ abs($item['days_until']) != 1 ? 's' : '' }}
                            @endif
                        </div>
                    </td>
                    <td class="px-3 py-2 text-right">
                        <div class="text-sm font-bold text-gray-900">${{ number_format($item['payment']->amount, 0, ',', '.') }}</div>
                        <div class="text-xs text-gray-500">Cuota #{{ $item['payment']->payment_number }}</div>
                    </td>
                    <td class="px-3 py-2 text-sm text-gray-700">
                        {{ ucfirst($item['contract']->payment_frequency) }}
                    </td>
                    <td class="px-3 py-2 text-center">
                        <button onclick="Livewire.dispatch('openPaymentModal', { contractId: {{ $item['contract']->id }} })" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Registrar Pago
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="text-center py-8">
            <p class="text-gray-500">✅ No hay pagos próximos {{ $filter === 'today' ? 'para hoy' : 'esta semana' }}</p>
        </div>
        @endif
    </div>
</div>
