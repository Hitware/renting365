<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($contracts->isEmpty())
                <!-- No Contracts Message -->
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No hay contratos disponibles</h3>
                    <p class="text-gray-500">Actualmente no tienes contratos de financiamiento activos.</p>
                </div>
            @else
                <!-- Contract Selector (if multiple contracts) -->
                @if($contracts->count() > 1)
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Selecciona un Contrato</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($contracts as $contract)
                                <button
                                    wire:click="selectContract({{ $contract['id'] }})"
                                    class="p-4 rounded-lg border-2 transition-all {{ $selectedContract == $contract['id'] ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-orange-300' }}">
                                    <div class="flex items-start justify-between mb-2">
                                        <p class="text-sm font-semibold text-gray-900">{{ $contract['contract_number'] }}</p>
                                        <span class="px-2 py-1 text-xs rounded-full {{ $contract['status_color'] }}">
                                            {{ $contract['status_label'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-1">{{ $contract['motorcycle'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $contract['total_paid'] }}/{{ $contract['term_months'] }} cuotas pagadas</p>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($selectedContractData)
                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Cuotas Pagadas -->
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-600">Cuotas Pagadas</p>
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-3xl font-bold text-gray-900">{{ $selectedContractData['total_paid'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">de {{ $selectedContractData['term_months'] }} totales</p>
                            <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($selectedContractData['total_paid'] / $selectedContractData['term_months']) * 100 }}%"></div>
                            </div>
                        </div>

                        <!-- Cuotas Pendientes -->
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-600">Cuotas Pendientes</p>
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-3xl font-bold text-gray-900">{{ $selectedContractData['total_pending'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">cuotas restantes</p>
                        </div>

                        <!-- Saldo Pendiente -->
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-600">Saldo Pendiente</p>
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-3xl font-bold text-gray-900">${{ number_format($selectedContractData['pending_balance'], 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500 mt-1">por pagar</p>
                        </div>

                        <!-- Próximo Pago -->
                        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 {{ $selectedContractData['next_payment'] && $selectedContractData['next_payment']->status == 'atrasado' ? 'border-red-500' : 'border-purple-500' }}">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-sm font-medium text-gray-600">Próximo Pago</p>
                                <div class="w-10 h-10 {{ $selectedContractData['next_payment'] && $selectedContractData['next_payment']->status == 'atrasado' ? 'bg-red-100' : 'bg-purple-100' }} rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 {{ $selectedContractData['next_payment'] && $selectedContractData['next_payment']->status == 'atrasado' ? 'text-red-600' : 'text-purple-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            @if($selectedContractData['next_payment'])
                                <p class="text-2xl font-bold text-gray-900">${{ number_format($selectedContractData['next_payment']->amount, 0, ',', '.') }}</p>
                                <p class="text-xs {{ $selectedContractData['next_payment']->status == 'atrasado' ? 'text-red-600 font-semibold' : 'text-gray-500' }} mt-1">
                                    {{ $selectedContractData['next_payment']->due_date->format('d/m/Y') }}
                                    @if($selectedContractData['next_payment']->status == 'atrasado')
                                        ({{ $selectedContractData['next_payment']->due_date->diffInDays(now()) }} días mora)
                                    @endif
                                </p>
                            @else
                                <p class="text-lg font-semibold text-green-600">¡Todo pago!</p>
                                <p class="text-xs text-gray-500 mt-1">Sin pagos pendientes</p>
                            @endif
                        </div>
                    </div>

                    <!-- Contract Details -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Detalles del Contrato</h3>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $selectedContractData['status_color'] }}">
                                {{ $selectedContractData['status_label'] }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <p class="text-sm text-gray-600">Número de Contrato</p>
                                <p class="text-base font-semibold text-gray-900">{{ $selectedContractData['contract_number'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Motocicleta</p>
                                <p class="text-base font-semibold text-gray-900">{{ $selectedContractData['motorcycle'] }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Fecha de Inicio</p>
                                <p class="text-base font-semibold text-gray-900">{{ \Carbon\Carbon::parse($selectedContractData['start_date'])->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Cuota Mensual</p>
                                <p class="text-base font-semibold text-gray-900">${{ number_format($selectedContractData['monthly_payment'], 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Plazo</p>
                                <p class="text-base font-semibold text-gray-900">{{ $selectedContractData['term_months'] }} meses</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Progreso</p>
                                <p class="text-base font-semibold text-gray-900">{{ round(($selectedContractData['total_paid'] / $selectedContractData['term_months']) * 100) }}%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Schedule Table -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Cronograma de Pagos</h3>
                            <p class="text-sm text-gray-600 mt-1">Historial completo de cuotas y pagos realizados</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuota</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Vencimiento</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Pago</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Método</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($selectedContractData['payments'] as $payment)
                                        <tr class="hover:bg-gray-50 {{ $payment->status == 'atrasado' ? 'bg-red-50' : '' }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full {{ $payment->status == 'pagado' ? 'bg-green-100' : ($payment->status == 'atrasado' ? 'bg-red-100' : 'bg-gray-100') }} flex items-center justify-center mr-3">
                                                        @if($payment->status == 'pagado')
                                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        @elseif($payment->status == 'atrasado')
                                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/>
                                                            </svg>
                                                        @else
                                                            <span class="text-xs font-semibold text-gray-600">{{ $payment->payment_number }}</span>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-semibold text-gray-900">Cuota #{{ $payment->payment_number }}</p>
                                                        <p class="text-xs text-gray-500">de {{ $selectedContractData['term_months'] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <p class="text-sm {{ $payment->status == 'atrasado' ? 'text-red-600 font-semibold' : 'text-gray-900' }}">
                                                    {{ $payment->due_date->format('d/m/Y') }}
                                                </p>
                                                @if($payment->status == 'atrasado')
                                                    <p class="text-xs text-red-600">{{ $payment->due_date->diffInDays(now()) }} días mora</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <p class="text-sm font-bold text-gray-900">${{ number_format($payment->amount, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <p class="text-sm text-gray-600">${{ number_format($payment->balance, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($payment->status == 'pagado')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Pagado
                                                    </span>
                                                @elseif($payment->status == 'atrasado')
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        En Mora
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pendiente
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($payment->paid_at)
                                                    <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y') }}</p>
                                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($payment->paid_at)->format('H:i') }}</p>
                                                @else
                                                    <p class="text-sm text-gray-400">-</p>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($payment->payment_method)
                                                    <p class="text-sm text-gray-900 capitalize">{{ $payment->payment_method }}</p>
                                                    @if($payment->reference_number)
                                                        <p class="text-xs text-gray-500">Ref: {{ $payment->reference_number }}</p>
                                                    @endif
                                                @else
                                                    <p class="text-sm text-gray-400">-</p>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Notes (if any paid with notes) -->
                    @php
                        $paymentsWithNotes = $selectedContractData['payments']->filter(function($payment) {
                            return $payment->status == 'pagado' && !empty($payment->notes);
                        });
                    @endphp

                    @if($paymentsWithNotes->isNotEmpty())
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notas de Pagos</h3>
                            <div class="space-y-3">
                                @foreach($paymentsWithNotes as $payment)
                                    <div class="p-4 bg-gray-50 rounded-lg border-l-4 border-blue-500">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="text-sm font-semibold text-gray-900">Cuota #{{ $payment->payment_number }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <p class="text-sm text-gray-700">{{ $payment->notes }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                @endif
            @endif
        </div>
    </div>
</div>
