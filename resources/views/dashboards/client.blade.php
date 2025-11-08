<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    Hola, {{ $client->full_name }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">Bienvenido a tu panel de cliente</p>
            </div>
            <div class="text-sm text-gray-600">
                {{ today()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">

                @if($overduePayments > 0)
                    <!-- Alerta de Pagos en Mora -->
                    <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-base font-semibold text-red-800">Tienes {{ $overduePayments }} {{ $overduePayments == 1 ? 'pago vencido' : 'pagos vencidos' }}</h3>
                                <p class="mt-1 text-sm text-red-700">Por favor, contacta a tu asesor para regularizar tu situación. WhatsApp: +57 310 5367376</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Contratos Activos -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-600">Contratos Activos</p>
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">{{ $activeContracts }}</p>
                        <p class="text-xs text-gray-500 mt-1">de {{ $totalContracts }} totales</p>
                    </div>

                    <!-- Total Pagado -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-600">Total Pagado</p>
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">${{ number_format($totalPaid, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">acumulado</p>
                    </div>

                    <!-- Saldo Pendiente -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-600">Saldo Pendiente</p>
                            <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-gray-900">${{ number_format($totalPending, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500 mt-1">por pagar</p>
                    </div>

                    <!-- Pagos en Mora -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 {{ $overduePayments > 0 ? 'border-red-500' : 'border-gray-300' }}">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-sm font-medium text-gray-600">Pagos en Mora</p>
                            <div class="w-10 h-10 {{ $overduePayments > 0 ? 'bg-red-100' : 'bg-gray-100' }} rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 {{ $overduePayments > 0 ? 'text-red-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold {{ $overduePayments > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $overduePayments }}</p>
                        <p class="text-xs {{ $overduePayments > 0 ? 'text-red-600' : 'text-gray-500' }} mt-1">
                            {{ $overduePayments > 0 ? 'Requiere atención' : 'Todo al día' }}
                        </p>
                    </div>
                </div>

                <!-- Mis Contratos -->
                <div class="bg-white rounded-xl shadow-md">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Mis Contratos</h3>
                        <p class="text-sm text-gray-600 mt-1">Resumen de tus contratos de financiamiento</p>
                    </div>

                    @if($contracts->isEmpty())
                        <div class="p-12 text-center">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500">No tienes contratos activos en este momento</p>
                        </div>
                    @else
                        <div class="p-6 space-y-4">
                            @foreach($contracts as $contract)
                                <div class="border border-gray-200 rounded-lg p-5 hover:border-orange-300 transition">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h4 class="text-base font-semibold text-gray-900">{{ $contract->motorcycle->brand }} {{ $contract->motorcycle->model }}</h4>
                                                @if($contract->status == 'activo')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 font-semibold">Al Día</span>
                                                @elseif($contract->status == 'mora')
                                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 font-semibold">En Mora</span>
                                                @else
                                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-semibold">Completado</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600">Contrato #{{ $contract->contract_number }}</p>
                                            <p class="text-xs text-gray-500 mt-1">Placa: {{ $contract->motorcycle->plate }} | {{ $contract->motorcycle->year }}</p>
                                        </div>
                                        <a href="{{ route('leasing-contracts.show', $contract) }}"
                                           class="px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition">
                                            Ver Detalles
                                        </a>
                                    </div>

                                    @php
                                        $totalPayments = $contract->payments->count();
                                        $paidPayments = $contract->payments->where('status', 'pagado')->count();
                                        $progress = $totalPayments > 0 ? ($paidPayments / $totalPayments) * 100 : 0;
                                        $pendingBalance = $contract->payments->whereIn('status', ['pendiente', 'atrasado'])->sum('amount');
                                        $nextPayment = $contract->payments()->whereIn('status', ['pendiente', 'atrasado'])->orderBy('payment_number')->first();
                                    @endphp

                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-3">
                                        <div>
                                            <p class="text-xs text-gray-500">Cuota Mensual</p>
                                            <p class="text-sm font-bold text-gray-900">${{ number_format($contract->monthly_payment, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Cuotas Pagadas</p>
                                            <p class="text-sm font-bold text-gray-900">{{ $paidPayments }} de {{ $totalPayments }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Saldo Pendiente</p>
                                            <p class="text-sm font-bold text-gray-900">${{ number_format($pendingBalance, 0, ',', '.') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Próximo Pago</p>
                                            @if($nextPayment)
                                                <p class="text-sm font-bold {{ $nextPayment->status == 'atrasado' ? 'text-red-600' : 'text-gray-900' }}">
                                                    {{ $nextPayment->due_date->format('d/m/Y') }}
                                                </p>
                                            @else
                                                <p class="text-sm font-bold text-green-600">Completo</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-orange-500 h-2 rounded-full transition-all" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ round($progress) }}% completado</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Próximos Pagos -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Próximos Pagos</h3>
                            <p class="text-sm text-gray-600 mt-1">Vencimientos en los próximos 30 días</p>
                        </div>
                        <div class="p-6">
                            @if($upcomingPayments->isEmpty())
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm">No tienes pagos próximos</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach($upcomingPayments as $payment)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg {{ $payment->status == 'atrasado' ? 'border-l-4 border-red-500' : '' }}">
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-gray-900">{{ $payment->contract->motorcycle->brand }} {{ $payment->contract->motorcycle->model }}</p>
                                                <p class="text-xs text-gray-600">Cuota #{{ $payment->payment_number }}</p>
                                                <p class="text-xs {{ $payment->status == 'atrasado' ? 'text-red-600 font-semibold' : 'text-gray-500' }} mt-1">
                                                    {{ $payment->due_date->format('d/m/Y') }}
                                                    @if($payment->status == 'atrasado')
                                                        - {{ $payment->due_date->diffInDays(now()) }} días mora
                                                    @else
                                                        - {{ $payment->due_date->diffForHumans() }}
                                                    @endif
                                                </p>
                                            </div>
                                            <p class="text-base font-bold {{ $payment->status == 'atrasado' ? 'text-red-600' : 'text-gray-900' }}">
                                                ${{ number_format($payment->amount, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Últimos Pagos Realizados -->
                    <div class="bg-white rounded-xl shadow-md">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Últimos Pagos Realizados</h3>
                            <p class="text-sm text-gray-600 mt-1">Historial de pagos recientes</p>
                        </div>
                        <div class="p-6">
                            @if($recentPayments->isEmpty())
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-gray-500 text-sm">No hay pagos realizados aún</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach($recentPayments as $payment)
                                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border-l-4 border-green-500">
                                            <div class="flex items-start flex-1">
                                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-gray-900">{{ $payment->contract->motorcycle->brand }} {{ $payment->contract->motorcycle->model }}</p>
                                                    <p class="text-xs text-gray-600">Cuota #{{ $payment->payment_number }}</p>
                                                    <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($payment->paid_at)->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                            <p class="text-base font-bold text-green-600">
                                                ${{ number_format($payment->amount_paid, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-md p-6 text-white">
                    <h3 class="text-lg font-semibold mb-4">Acciones Rápidas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="https://api.whatsapp.com/send?phone=573105367376&text=Hola!%20Necesito%20ayuda%20con%20mi%20contrato"
                           target="_blank"
                           class="flex items-center p-4 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition">
                            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            <div>
                                <p class="font-semibold">WhatsApp</p>
                                <p class="text-xs opacity-90">Chatea con un asesor</p>
                            </div>
                        </a>

                        <a href="tel:+573105367376"
                           class="flex items-center p-4 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition">
                            <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div>
                                <p class="font-semibold">Llamar</p>
                                <p class="text-xs opacity-90">+57 310 5367376</p>
                            </div>
                        </a>

                        @if($totalContracts > 0)
                            <a href="{{ route('client.account') }}"
                               class="flex items-center p-4 bg-white bg-opacity-20 rounded-lg hover:bg-opacity-30 transition">
                                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="font-semibold">Estado de Cuenta</p>
                                    <p class="text-xs opacity-90">Ver detalles completos</p>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
