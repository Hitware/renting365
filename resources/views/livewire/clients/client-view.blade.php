<div class="space-y-6">
    <!-- Header del cliente -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $client->full_name }}</h2>
                <p class="text-gray-600">{{ $client->document_type }} {{ $client->document_number }}</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $client->status_badge_color }}">
                    {{ $client->status_label }}
                </span>
                @if($client->credit_score)
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $client->credit_score }}</p>
                    <p class="text-xs text-gray-500">Score</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabs de navegación -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button wire:click="setActiveTab('personal')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'personal' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    📝 Personal
                </button>
                <button wire:click="setActiveTab('laboral')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'laboral' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    💼 Laboral
                </button>
                <button wire:click="setActiveTab('financiero')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'financiero' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    💰 Financiero
                </button>
                <button wire:click="setActiveTab('referencias')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'referencias' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    📞 Referencias
                </button>
                <button wire:click="setActiveTab('creditos')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'creditos' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    💳 Créditos
                </button>
                <button wire:click="setActiveTab('documentos')" 
                        class="px-6 py-4 text-sm font-medium border-b-2 {{ $activeTab === 'documentos' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    📄 Documentos
                </button>
            </nav>
        </div>

        <div class="p-6">
            <!-- Tab: Personal -->
            @if($activeTab === 'personal')
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Nombre Completo</h3>
                        <p class="text-base text-gray-900">{{ $client->full_name }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Fecha de Nacimiento</h3>
                        <p class="text-base text-gray-900">{{ $client->birth_date->format('d/m/Y') }} ({{ $client->age }} años)</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Género</h3>
                        <p class="text-base text-gray-900">{{ $client->gender }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Estado Civil</h3>
                        <p class="text-base text-gray-900">{{ ucfirst($client->marital_status) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Nivel Educativo</h3>
                        <p class="text-base text-gray-900">{{ ucfirst($client->education_level) }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Personas a Cargo</h3>
                        <p class="text-base text-gray-900">{{ $client->dependents_count }}</p>
                    </div>
                </div>

                @if($client->contacts->count() > 0)
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Información de Contacto</h3>
                    @foreach($client->contacts as $contact)
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="font-medium text-gray-900 mb-2">{{ ucfirst($contact->contact_type) }}</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Dirección:</span>
                                <span class="text-gray-900">{{ $contact->address }}, {{ $contact->city }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Teléfono:</span>
                                <span class="text-gray-900">{{ $contact->phone_mobile }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Email:</span>
                                <span class="text-gray-900">{{ $contact->email }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endif

            <!-- Tab: Laboral -->
            @if($activeTab === 'laboral')
            <div class="space-y-6">
                @if($client->currentEmployment)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Empleo Actual</h3>
                        <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-semibold rounded-full">Activo</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Empleador</p>
                            <p class="text-base font-medium text-gray-900">{{ $client->currentEmployment->employer_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Cargo</p>
                            <p class="text-base font-medium text-gray-900">{{ $client->currentEmployment->position }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tipo de Empleo</p>
                            <p class="text-base font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $client->currentEmployment->employment_type)) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Antigüedad</p>
                            <p class="text-base font-medium text-gray-900">{{ $client->currentEmployment->start_date->diffForHumans() }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Salario Mensual</p>
                            <p class="text-base font-medium text-gray-900">${{ number_format($client->currentEmployment->monthly_salary, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <p>No hay información laboral registrada</p>
                </div>
                @endif
            </div>
            @endif

            <!-- Tab: Financiero -->
            @if($activeTab === 'financiero')
            <div class="space-y-6">
                @if($client->latestFinancial)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <p class="text-sm text-blue-600 mb-1">Ingresos Totales</p>
                        <p class="text-2xl font-bold text-blue-900">${{ number_format($client->latestFinancial->total_income, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                        <p class="text-sm text-red-600 mb-1">Egresos Totales</p>
                        <p class="text-2xl font-bold text-red-900">${{ number_format($client->latestFinancial->total_expenses, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <p class="text-sm text-green-600 mb-1">Ingreso Disponible</p>
                        <p class="text-2xl font-bold text-green-900">${{ number_format($client->latestFinancial->disposable_income, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if($client->latestFinancial->debt_to_income_ratio)
                <div class="bg-gray-50 rounded-lg p-6">
                    <h4 class="font-medium text-gray-900 mb-2">Ratio de Endeudamiento</h4>
                    <div class="flex items-center">
                        <div class="flex-1 bg-gray-200 rounded-full h-4">
                            <div class="bg-orange-600 h-4 rounded-full" style="width: {{ min($client->latestFinancial->debt_to_income_ratio * 100, 100) }}%"></div>
                        </div>
                        <span class="ml-4 text-lg font-bold text-gray-900">{{ number_format($client->latestFinancial->debt_to_income_ratio * 100, 1) }}%</span>
                    </div>
                </div>
                @endif
                @else
                <div class="text-center py-8 text-gray-500">
                    <p>No hay información financiera registrada</p>
                </div>
                @endif
            </div>
            @endif

            <!-- Tab: Referencias -->
            @if($activeTab === 'referencias')
            <div class="space-y-4">
                @forelse($client->references as $reference)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-900">{{ $reference->full_name }}</h4>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $reference->verification_status === 'verificada' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $reference->verification_status === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $reference->verification_status === 'no_verificada' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($reference->verification_status) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Tipo:</span>
                            <span class="text-gray-900">{{ ucfirst($reference->reference_type) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Teléfono:</span>
                            <span class="text-gray-900">{{ $reference->phone }}</span>
                        </div>
                        @if($reference->relationship)
                        <div>
                            <span class="text-gray-500">Relación:</span>
                            <span class="text-gray-900">{{ $reference->relationship }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <p>No hay referencias registradas</p>
                </div>
                @endforelse
            </div>
            @endif

            <!-- Tab: Créditos -->
            @if($activeTab === 'creditos')
            <div class="space-y-6">
                <!-- Botón para asignar contrato de leasing -->
                @can('clients.create')
                <div class="flex justify-end">
                    <a href="{{ route('leasing-contracts.create', ['client' => $client->getRouteKey()]) }}" 
                       class="inline-flex items-center px-4 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Asignar Contrato de Leasing
                    </a>
                </div>
                @endcan

                <!-- Contratos de Leasing del Cliente -->
                @php
                    $leasingContracts = $client->leasingContracts ?? collect();
                @endphp
                @if($leasingContracts->count() > 0)
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Contratos de Leasing</h3>
                    <div class="space-y-4">
                        @foreach($leasingContracts as $contract)
                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $contract->contract_number }}</h4>
                                    <p class="text-sm text-gray-600">{{ $contract->motorcycle->brand }} {{ $contract->motorcycle->model }} - {{ $contract->motorcycle->plate }}</p>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $contract->status_badge_color }}">
                                    {{ ucfirst($contract->status) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm mt-4">
                                <div>
                                    <span class="text-gray-500">Cuota Mensual:</span>
                                    <span class="text-gray-900 font-medium">${{ number_format($contract->monthly_payment, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Plazo:</span>
                                    <span class="text-gray-900">{{ $contract->term_months }} meses</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Pagos:</span>
                                    <span class="text-gray-900">{{ $contract->paid_payments_count }}/{{ $contract->term_months }}</span>
                                </div>
                                <div>
                                    <a href="{{ route('leasing-contracts.show', $contract) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Ver Detalle →
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @if($client->latestMidatacredito)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Consulta Midatacrédito</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Score</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $client->latestMidatacredito->score }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Créditos Activos</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $client->latestMidatacredito->active_credits_count }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Deuda Total</p>
                            <p class="text-2xl font-bold text-gray-900">${{ number_format($client->latestMidatacredito->total_debt, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Deuda Vencida</p>
                            <p class="text-2xl font-bold {{ $client->latestMidatacredito->overdue_debt > 0 ? 'text-red-600' : 'text-green-600' }}">
                                ${{ number_format($client->latestMidatacredito->overdue_debt, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                @forelse($client->credits as $credit)
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-900">{{ $credit->entity_name }}</h4>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                            {{ $credit->status === 'activo' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $credit->status === 'mora' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $credit->status === 'pagado' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ ucfirst($credit->status) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Tipo:</span>
                            <span class="text-gray-900">{{ ucfirst($credit->credit_type) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Saldo:</span>
                            <span class="text-gray-900">${{ number_format($credit->current_balance, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Cuota:</span>
                            <span class="text-gray-900">${{ number_format($credit->monthly_payment, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Día de Pago:</span>
                            <span class="text-gray-900">{{ $credit->payment_day }}</span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <p>No hay créditos registrados</p>
                </div>
                @endforelse
            </div>
            @endif

            <!-- Tab: Documentos -->
            @if($activeTab === 'documentos')
            <livewire:clients.document-upload :client="$client" :key="'doc-'.$client->id" />
            @endif
        </div>
    </div>
</div>
