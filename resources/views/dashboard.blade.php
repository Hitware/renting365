<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Dashboard - {{ auth()->user()->roles->first()->name ?? 'Usuario' }}
        </h2>
    </x-slot>

    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl shadow-xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-3xl font-bold mb-2">
                        ¡Bienvenido, {{ auth()->user()->profile->first_name ?? auth()->user()->name }}!
                    </h3>
                    <p class="text-orange-100 text-lg">
                        Hoy es {{ now()->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    </p>
                </div>
                <div class="hidden md:block">
                    <div class="w-24 h-24 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @can('clients.view')
            <!-- Pagos Pendientes Hoy -->
            <a href="{{ route('payments.today') }}" class="bg-white rounded-xl shadow-md p-6 border-l-4 border-orange-500 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Pagos de Hoy</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ \App\Models\LeasingPayment::whereDate('due_date', today())->whereIn('status', ['pendiente', 'atrasado'])->count() }}
                        </p>
                        <p class="text-xs text-orange-600 mt-1">
                            ${{ number_format(\App\Models\LeasingPayment::whereDate('due_date', today())->whereIn('status', ['pendiente', 'atrasado'])->sum('amount'), 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endcan

            @can('clients.view')
            <!-- Pagos en Mora -->
            <a href="{{ route('payments.overdue') }}" class="bg-white rounded-xl shadow-md p-6 border-l-4 border-red-500 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Pagos en Mora</p>
                        <p class="text-3xl font-bold text-red-600">
                            {{ \App\Models\LeasingPayment::where('status', 'atrasado')->count() }}
                        </p>
                        <p class="text-xs text-red-600 mt-1">Requieren atención</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endcan

            @can('users.view')
            <!-- Total Users Card -->
            <a href="{{ route('users.index') }}" class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Usuarios</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Click para gestionar</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endcan

            @can('motorcycles.view')
            <!-- Total Motorcycles Card -->
            <a href="{{ route('motorcycles.index') }}" class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Motocicletas</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \DB::table('motorcycles')->count() }}</p>
                        <p class="text-xs text-gray-500 mt-1">Click para gestionar</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </a>
            @endcan

            @can('motorcycles.view')
            <!-- Active Motorcycles Card -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Motos Activas</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \DB::table('motorcycles')->where('status', 'active')->count() }}</p>
                        <p class="text-xs text-green-600 mt-1">En operación</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            @endcan

            @can('maintenance.view')
            <!-- Pending Maintenance Card -->
            <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Mantenimientos Pendientes</p>
                        <p class="text-3xl font-bold text-gray-900">{{ \DB::table('motorcycle_maintenances')->where('status', 'pending')->count() }}</p>
                        <p class="text-xs text-yellow-600 mt-1">Requieren atención</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            @endcan
        </div>

        <!-- Pagos Próximos y Atrasados -->
        @can('clients.view')
        <div class="space-y-6">
            <livewire:dashboard.upcoming-payments />
            <livewire:dashboard.overdue-payments />
        </div>
        @endcan

        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @can('clients.view')
            <!-- Pagos del Día -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pagos del Día
                    </h3>
                    <a href="{{ route('payments.today') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                        Ver todos →
                    </a>
                </div>
                <div class="space-y-3">
                    @php
                        $todayPayments = \App\Models\LeasingPayment::with(['contract.client'])
                            ->whereDate('due_date', today())
                            ->whereIn('status', ['pendiente', 'atrasado'])
                            ->orderBy('due_date')
                            ->limit(5)
                            ->get();
                    @endphp
                    @forelse($todayPayments as $payment)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-900">{{ $payment->contract->client->full_name }}</p>
                                <p class="text-xs text-gray-500">Cuota #{{ $payment->payment_number }} - {{ $payment->contract->contract_number }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-orange-600">${{ number_format($payment->amount, 0, ',', '.') }}</p>
                                @if($payment->status == 'atrasado')
                                <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full">Mora</span>
                                @else
                                <span class="text-xs px-2 py-0.5 bg-green-100 text-green-700 rounded-full">Hoy</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500 text-sm">No hay pagos programados para hoy</p>
                        </div>
                    @endforelse
                </div>
            </div>
            @else
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Actividad Reciente
                </h3>
                <div class="space-y-4">
                    @forelse(auth()->user()->activityLogs()->latest()->take(5)->get() as $log)
                        <div class="flex items-start pb-4 border-b border-gray-100 last:border-0">
                            <div class="flex-shrink-0 w-2 h-2 bg-orange-500 rounded-full mt-2"></div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $log->action }}</p>
                                <p class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-8">No hay actividad reciente</p>
                    @endforelse
                </div>
            </div>
            @endcan

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Acciones Rápidas
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    @can('clients.create')
                    <a href="{{ route('payments.create') }}" class="group bg-gradient-to-br from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-lg p-4 transition-all duration-200 border border-green-200">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Registrar Pago</p>
                        </div>
                    </a>
                    @endcan

                    @can('motorcycles.create')
                    <a href="{{ route('motorcycles.create') }}" class="group bg-gradient-to-br from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 rounded-lg p-4 transition-all duration-200 border border-orange-200">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-orange-600 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Nueva Moto</p>
                        </div>
                    </a>
                    @endcan

                    @can('users.create')
                    <a href="{{ route('users.create') }}" class="group bg-gradient-to-br from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 rounded-lg p-4 transition-all duration-200 border border-blue-200">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Nuevo Usuario</p>
                        </div>
                    </a>
                    @endcan

                    @can('users.view')
                    <a href="{{ route('users.index') }}" class="group bg-gradient-to-br from-purple-50 to-pink-50 hover:from-purple-100 hover:to-pink-100 rounded-lg p-4 transition-all duration-200 border border-purple-200">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-purple-600 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Ver Usuarios</p>
                        </div>
                    </a>
                    @endcan

                    @can('motorcycles.view')
                    <a href="{{ route('motorcycles.index') }}" class="group bg-gradient-to-br from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-lg p-4 transition-all duration-200 border border-green-200">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Ver Motocicletas</p>
                        </div>
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- User Info Card -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Información de la Cuenta
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Nombre Completo</p>
                    <p class="text-base font-medium text-gray-900">{{ auth()->user()->profile->full_name ?? auth()->user()->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Email</p>
                    <p class="text-base font-medium text-gray-900">{{ auth()->user()->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Rol</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800">
                        {{ auth()->user()->roles->first()->name ?? 'Sin rol' }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-500 mb-1">Último Acceso</p>
                    <p class="text-base font-medium text-gray-900">{{ auth()->user()->last_login_at?->diffForHumans() ?? 'Nunca' }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
