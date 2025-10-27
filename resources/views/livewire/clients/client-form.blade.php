<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header con progreso -->
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-8 py-6">
            <h2 class="text-2xl font-bold text-white mb-4">{{ $isEditing ? 'Editar Cliente' : 'Registro de Nuevo Cliente' }}</h2>
            
            <!-- Indicador de pasos -->
            <div class="flex items-center justify-between mb-4">
                @for($i = 1; $i <= $totalSteps; $i++)
                <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold
                            {{ $currentStep >= $i ? 'bg-white text-orange-600' : 'bg-orange-400 text-white' }}">
                            @if($currentStep > $i)
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                {{ $i }}
                            @endif
                        </div>
                        <div class="absolute top-12 left-1/2 transform -translate-x-1/2 whitespace-nowrap text-xs text-white font-medium">
                            {{ ['Personal', 'Contacto', 'Laboral', 'Financiero', 'Referencias', 'Consentimientos'][$i-1] }}
                        </div>
                    </div>
                    @if($i < $totalSteps)
                    <div class="flex-1 h-1 mx-2 {{ $currentStep > $i ? 'bg-white' : 'bg-orange-400' }}"></div>
                    @endif
                </div>
                @endfor
            </div>
        </div>

        <form wire:submit.prevent="submit" class="p-8">
            <!-- Mensajes de error generales -->
            @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="text-sm font-medium text-red-800 mb-2">Por favor corrige los siguientes errores:</h3>
                <ul class="list-disc list-inside text-sm text-red-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Paso 1: Datos Personales -->
            @if($currentStep === 1)
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Información Personal</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Documento *</label>
                        <select wire:model="document_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <option value="CC">Cédula de Ciudadanía</option>
                            <option value="CE">Cédula de Extranjería</option>
                            <option value="TI">Tarjeta de Identidad</option>
                            <option value="PP">Pasaporte</option>
                        </select>
                        @error('document_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Número de Documento *</label>
                        <input type="text" wire:model="document_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('document_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primer Nombre *</label>
                        <input type="text" wire:model="first_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Segundo Nombre</label>
                        <input type="text" wire:model="middle_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Primer Apellido *</label>
                        <input type="text" wire:model="last_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Segundo Apellido</label>
                        <input type="text" wire:model="second_last_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Nacimiento *</label>
                        <input type="date" wire:model="birth_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('birth_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lugar de Nacimiento</label>
                        <input type="text" wire:model="birth_place" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Género *</label>
                        <select wire:model="gender" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="Otro">Otro</option>
                            <option value="Prefiero no decir">Prefiero no decir</option>
                        </select>
                        @error('gender') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Estado Civil *</label>
                        <select wire:model="marital_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <option value="">Seleccione...</option>
                            <option value="soltero">Soltero(a)</option>
                            <option value="casado">Casado(a)</option>
                            <option value="union_libre">Unión Libre</option>
                            <option value="divorciado">Divorciado(a)</option>
                            <option value="viudo">Viudo(a)</option>
                        </select>
                        @error('marital_status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nivel Educativo *</label>
                        <select wire:model="education_level" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <option value="">Seleccione...</option>
                            <option value="primaria">Primaria</option>
                            <option value="secundaria">Secundaria</option>
                            <option value="tecnico">Técnico</option>
                            <option value="tecnologo">Tecnólogo</option>
                            <option value="profesional">Profesional</option>
                            <option value="posgrado">Posgrado</option>
                        </select>
                        @error('education_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Personas a Cargo</label>
                        <input type="number" wire:model="dependents_count" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
            </div>
            @endif

            <!-- Paso 2: Contacto -->
            @if($currentStep === 2)
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Información de Contacto</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dirección de Residencia *</label>
                        <input type="text" wire:model="address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Barrio</label>
                        <input type="text" wire:model="neighborhood" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ciudad *</label>
                        <input type="text" wire:model="city" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Departamento *</label>
                        <input type="text" wire:model="department" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('department') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono Celular *</label>
                        <input type="text" wire:model="phone_mobile" placeholder="+57 300 123 4567" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('phone_mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono Fijo</label>
                        <input type="text" wire:model="phone_landline" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico *</label>
                        <input type="email" wire:model="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @endif

            <!-- Paso 3: Información Laboral -->
            @if($currentStep === 3)
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Información Laboral</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Empleo *</label>
                        <select wire:model="employment_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            <option value="">Seleccione...</option>
                            <option value="empleado_indefinido">Empleado Indefinido</option>
                            <option value="empleado_temporal">Empleado Temporal</option>
                            <option value="prestacion_servicios">Prestación de Servicios</option>
                            <option value="independiente">Independiente</option>
                            <option value="pensionado">Pensionado</option>
                        </select>
                        @error('employment_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nombre del Empleador *</label>
                        <input type="text" wire:model="employer_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('employer_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">NIT del Empleador</label>
                        <input type="text" wire:model="employer_nit" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cargo *</label>
                        <input type="text" wire:model="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('position') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Salario Mensual *</label>
                        <input type="number" wire:model="monthly_salary" min="1300000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('monthly_salary') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio *</label>
                        <input type="date" wire:model="start_date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @endif

            <!-- Paso 4: Información Financiera -->
            @if($currentStep === 4)
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Información Financiera</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ingresos Totales Mensuales *</label>
                        <input type="number" wire:model="total_income" min="1300000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('total_income') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Egresos Totales Mensuales *</label>
                        <input type="number" wire:model="total_expenses" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        @error('total_expenses') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gasto en Arriendo</label>
                        <input type="number" wire:model="rent_expense" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gasto en Servicios</label>
                        <input type="number" wire:model="utilities_expense" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gasto en Alimentación</label>
                        <input type="number" wire:model="food_expense" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                    </div>

                    @if($total_income && $total_expenses)
                    <div class="md:col-span-2 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm font-medium text-blue-900">Ingreso Disponible: ${{ number_format($total_income - $total_expenses, 0, ',', '.') }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Paso 5: Referencias -->
            @if($currentStep === 5)
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Referencias</h3>
                
                @foreach($references as $index => $reference)
                <div class="border border-gray-200 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3">Referencia {{ $index + 1 }} - {{ ucfirst($reference['type']) }}</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                            <input type="text" wire:model="references.{{ $index }}.name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            @error("references.{$index}.name") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teléfono *</label>
                            <input type="text" wire:model="references.{{ $index }}.phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                            @error("references.{$index}.phone") <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Parentesco/Relación</label>
                            <input type="text" wire:model="references.{{ $index }}.relationship" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            <!-- Paso 6: Consentimientos -->
            @if($currentStep === 6)
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Consentimientos y Autorizaciones</h3>
                
                <div class="space-y-4">
                    <div class="border border-gray-200 rounded-lg p-6">
                        <label class="flex items-start">
                            <input type="checkbox" wire:model="consent_data_treatment" class="mt-1 mr-3 h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">
                                <strong>Autorización de Tratamiento de Datos Personales *</strong><br>
                                Autorizo de manera libre, previa, expresa e informada a Renting365 para recolectar, almacenar, usar, circular, suprimir, procesar, compilar, intercambiar, dar tratamiento, actualizar y disponer de los datos que he suministrado y que suministraré en el futuro.
                            </span>
                        </label>
                        @error('consent_data_treatment') <span class="text-red-500 text-sm block mt-2">{{ $message }}</span> @enderror
                    </div>

                    <div class="border border-gray-200 rounded-lg p-6">
                        <label class="flex items-start">
                            <input type="checkbox" wire:model="consent_credit_query" class="mt-1 mr-3 h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <span class="text-sm text-gray-700">
                                <strong>Autorización de Consulta a Centrales de Riesgo *</strong><br>
                                Autorizo a Renting365 para consultar, reportar y divulgar a las centrales de información toda la información referente al nacimiento, ejecución y extinción de obligaciones que he contraído o que contraiga en el futuro.
                            </span>
                        </label>
                        @error('consent_credit_query') <span class="text-red-500 text-sm block mt-2">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            @endif

            <!-- Botones de navegación -->
            <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                @if($currentStep > 1)
                <button type="button" wire:click.prevent="previousStep" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition-colors">
                    ← Anterior
                </button>
                @else
                <div></div>
                @endif

                @if($currentStep < $totalSteps)
                <button type="button" wire:click.prevent="nextStep" wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed" class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-medium rounded-lg transition-colors">
                    <span wire:loading.remove wire:target="nextStep">Siguiente →</span>
                    <span wire:loading wire:target="nextStep">Procesando...</span>
                </button>
                @else
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                    {{ $isEditing ? 'Actualizar Cliente' : 'Registrar Cliente' }}
                </button>
                @endif
            </div>
        </form>
    </div>
</div>
