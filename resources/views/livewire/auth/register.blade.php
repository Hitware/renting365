<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-4xl font-bold text-gray-900">
                Crear Cuenta en Renting365
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Completa el registro para comenzar a solicitar tu motocicleta
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                @for ($i = 1; $i <= $totalSteps; $i++)
                    <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                        <div class="relative flex items-center justify-center">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center border-2 transition-all duration-300
                                {{ $currentStep > $i ? 'bg-green-500 border-green-500 text-white' : '' }}
                                {{ $currentStep === $i ? 'bg-blue-600 border-blue-600 text-white ring-4 ring-blue-200' : '' }}
                                {{ $currentStep < $i ? 'bg-white border-gray-300 text-gray-400' : '' }}">
                                @if ($currentStep > $i)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <span class="text-sm font-semibold">{{ $i }}</span>
                                @endif
                            </div>
                        </div>
                        @if ($i < $totalSteps)
                            <div class="flex-1 h-1 mx-2 transition-all duration-300
                                {{ $currentStep > $i ? 'bg-green-500' : 'bg-gray-200' }}">
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
            <div class="flex justify-between mt-2 px-2">
                <span class="text-xs font-medium {{ $currentStep >= 1 ? 'text-blue-600' : 'text-gray-400' }}">Cuenta</span>
                <span class="text-xs font-medium {{ $currentStep >= 2 ? 'text-blue-600' : 'text-gray-400' }}">Datos Personales</span>
                <span class="text-xs font-medium {{ $currentStep >= 3 ? 'text-blue-600' : 'text-gray-400' }}">Confirmación</span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="px-8 py-10">
                <form wire:submit.prevent="{{ $currentStep === $totalSteps ? 'register' : 'nextStep' }}">
                    @csrf

                    <!-- Step 1: Account Information -->
                    @if ($currentStep === 1)
                        <div class="space-y-6 animate-fadeIn">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-6">Información de Cuenta</h3>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Correo Electrónico <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                        </svg>
                                    </div>
                                    <input wire:model.blur="email" type="email" id="email"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200
                                        @error('email') border-red-500 @enderror"
                                        placeholder="tu@email.com">
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Contraseña <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input wire:model="password" type="password" id="password"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200
                                        @error('password') border-red-500 @enderror"
                                        placeholder="Mínimo 8 caracteres">
                                </div>
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">
                                    Debe contener mayúsculas, minúsculas, números y caracteres especiales
                                </p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmar Contraseña <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <input wire:model="password_confirmation" type="password" id="password_confirmation"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Confirma tu contraseña">
                                </div>
                            </div>

                            <!-- Phone (Optional) -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Teléfono Celular
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <input wire:model.blur="phone" type="tel" id="phone"
                                        class="pl-10 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200
                                        @error('phone') border-red-500 @enderror"
                                        placeholder="3001234567">
                                </div>
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <!-- Step 2: Personal Information -->
                    @if ($currentStep === 2)
                        <div class="space-y-6 animate-fadeIn">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-6">Datos Personales</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- First Name -->
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nombres <span class="text-red-500">*</span>
                                    </label>
                                    <input wire:model="first_name" type="text" id="first_name"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200
                                        @error('first_name') border-red-500 @enderror"
                                        placeholder="Juan Carlos">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Last Name -->
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Apellidos <span class="text-red-500">*</span>
                                    </label>
                                    <input wire:model="last_name" type="text" id="last_name"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200
                                        @error('last_name') border-red-500 @enderror"
                                        placeholder="García López">
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Document Type -->
                                <div>
                                    <label for="document_type" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tipo de Documento <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="document_type" id="document_type"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                        <option value="CC">Cédula de Ciudadanía</option>
                                        <option value="CE">Cédula de Extranjería</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="PAS">Pasaporte</option>
                                        <option value="NIT">NIT</option>
                                    </select>
                                </div>

                                <!-- Document Number -->
                                <div>
                                    <label for="document_number" class="block text-sm font-medium text-gray-700 mb-2">
                                        Número de Documento <span class="text-red-500">*</span>
                                    </label>
                                    <input wire:model.blur="document_number" type="text" id="document_number"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200
                                        @error('document_number') border-red-500 @enderror"
                                        placeholder="1234567890">
                                    @error('document_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Birth Date -->
                            <div>
                                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha de Nacimiento
                                </label>
                                <input wire:model="birth_date" type="date" id="birth_date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    max="{{ date('Y-m-d') }}">
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Dirección
                                </label>
                                <input wire:model="address" type="text" id="address"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Calle 123 #45-67">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- City -->
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                        Ciudad
                                    </label>
                                    <input wire:model="city" type="text" id="city"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Bogotá">
                                </div>

                                <!-- State -->
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                                        Departamento
                                    </label>
                                    <input wire:model="state" type="text" id="state"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                        placeholder="Cundinamarca">
                                </div>

                                <!-- Postal Code -->
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                        Código Postal
                                    </label>
                                    <input wire:model="postal_code" type="text" id="postal_code"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                        placeholder="110111">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Step 3: Confirmation -->
                    @if ($currentStep === 3)
                        <div class="space-y-6 animate-fadeIn">
                            <h3 class="text-2xl font-semibold text-gray-900 mb-6">Confirmación</h3>

                            <!-- Summary -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                <h4 class="text-lg font-semibold text-blue-900 mb-4">Resumen de tu Información</h4>
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Nombre completo:</span>
                                        <span class="font-medium text-gray-900">{{ $first_name }} {{ $last_name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Correo electrónico:</span>
                                        <span class="font-medium text-gray-900">{{ $email }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Documento:</span>
                                        <span class="font-medium text-gray-900">{{ $document_type }} - {{ $document_number }}</span>
                                    </div>
                                    @if($phone)
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Teléfono:</span>
                                        <span class="font-medium text-gray-900">{{ $phone }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input wire:model="terms_accepted" type="checkbox" id="terms_accepted"
                                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </div>
                                    <div class="ml-3">
                                        <label for="terms_accepted" class="text-sm text-gray-700">
                                            Acepto los
                                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">términos y condiciones</a>
                                            y la
                                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">política de privacidad</a>
                                            de Renting365 <span class="text-red-500">*</span>
                                        </label>
                                        @error('terms_accepted')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            @error('registration')
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="text-sm text-red-800 flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="mt-8 flex justify-between items-center">
                        @if ($currentStep > 1)
                            <button type="button" wire:click="previousStep"
                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors duration-200 font-medium flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Anterior
                            </button>
                        @else
                            <div></div>
                        @endif

                        <button type="submit"
                            class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium shadow-lg hover:shadow-xl flex items-center">
                            @if ($currentStep === $totalSteps)
                                <span wire:loading.remove wire:target="register">Crear Cuenta</span>
                                <span wire:loading wire:target="register" class="flex items-center">
                                    <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Procesando...
                                </span>
                            @else
                                Siguiente
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Login Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                    Inicia Sesión
                </a>
            </p>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-in-out;
    }
</style>
