<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Registrar Nueva Motocicleta
            </h2>
            <a href="{{ route('motorcycles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 bg-gradient-to-r from-orange-500 to-orange-600">
                <h3 class="text-lg font-semibold text-white">Información de la Motocicleta</h3>
                <p class="text-sm text-orange-100 mt-1">Complete todos los campos requeridos para el registro</p>
            </div>

            <form action="{{ route('motorcycles.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <!-- Datos Técnicos -->
                <div>
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Datos Técnicos
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Marca *</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('brand') border-red-500 @enderror">
                            @error('brand')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="model" class="block text-sm font-medium text-gray-700 mb-2">Modelo *</label>
                            <input type="text" name="model" id="model" value="{{ old('model') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('model') border-red-500 @enderror">
                            @error('model')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700 mb-2">Año *</label>
                            <input type="number" name="year" id="year" value="{{ old('year', date('Y')) }}" required min="1900" max="{{ date('Y') + 1 }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('year') border-red-500 @enderror">
                            @error('year')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="displacement" class="block text-sm font-medium text-gray-700 mb-2">Cilindraje *</label>
                            <input type="text" name="displacement" id="displacement" value="{{ old('displacement') }}" required placeholder="ej: 150cc"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('displacement') border-red-500 @enderror">
                            @error('displacement')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                            <input type="text" name="color" id="color" value="{{ old('color') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('color') border-red-500 @enderror">
                            @error('color')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Estado *</label>
                            <select name="status" id="status" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('status') border-red-500 @enderror">
                                <option value="">Seleccione</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Activa</option>
                                <option value="in_maintenance" {{ old('status') == 'in_maintenance' ? 'selected' : '' }}>En Mantenimiento</option>
                                <option value="damaged" {{ old('status') == 'damaged' ? 'selected' : '' }}>Dañada</option>
                                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Vendida</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactiva</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Identificación -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                        </svg>
                        Identificación
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="plate" class="block text-sm font-medium text-gray-700 mb-2">Placa *</label>
                            <input type="text" name="plate" id="plate" value="{{ old('plate') }}" required placeholder="ABC123"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent uppercase @error('plate') border-red-500 @enderror">
                            @error('plate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Debe ser única</p>
                        </div>

                        <div>
                            <label for="motor_number" class="block text-sm font-medium text-gray-700 mb-2">Número de Motor *</label>
                            <input type="text" name="motor_number" id="motor_number" value="{{ old('motor_number') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent uppercase @error('motor_number') border-red-500 @enderror">
                            @error('motor_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="chassis_number" class="block text-sm font-medium text-gray-700 mb-2">Número de Chasis *</label>
                            <input type="text" name="chassis_number" id="chassis_number" value="{{ old('chassis_number') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent uppercase @error('chassis_number') border-red-500 @enderror">
                            @error('chassis_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Asignación -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Asignación
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <div>
                            <label for="current_owner_id" class="block text-sm font-medium text-gray-700 mb-2">Responsable Actual</label>
                            <select name="current_owner_id" id="current_owner_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('current_owner_id') border-red-500 @enderror">
                                <option value="">Sin asignar</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('current_owner_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} - {{ $user->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('current_owner_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información de Compra -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Información de Compra
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-2">Precio de Compra</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">$</span>
                                <input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" step="0.01" min="0"
                                       class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('purchase_price') border-red-500 @enderror">
                            </div>
                            @error('purchase_price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Compra</label>
                            <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('purchase_date') border-red-500 @enderror">
                            @error('purchase_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Notas -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-md font-semibold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Notas Adicionales
                    </h4>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('motorcycles.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors duration-200">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold rounded-lg transition-colors duration-200">
                        Registrar Motocicleta
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
