<div class="w-full">
    @if($showSuccess)
        <div class="bg-green-50 border-2 border-green-500 rounded-2xl p-8 text-center animate-fade-in">
            <div class="w-20 h-20 bg-green-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-green-800 mb-2">¡Solicitud Enviada!</h3>
            <p class="text-green-700 mb-6">Hemos recibido tu solicitud. Un asesor se contactará contigo pronto.</p>
            <button wire:click="$set('showSuccess', false)" class="px-8 py-3 bg-green-600 text-white rounded-full hover:bg-green-700 transition">
                Enviar Otra Solicitud
            </button>
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo *</label>
                    <input type="text" wire:model="full_name" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="Juan Pérez">
                    @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cédula *</label>
                    <input type="text" wire:model.blur="document_number" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="1234567890">
                    @error('document_number') 
                        <div class="mt-2 p-3 bg-yellow-50 border-l-4 border-yellow-500 rounded">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-yellow-700 text-sm font-medium">{{ $message }}</span>
                            </div>
                        </div>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono *</label>
                    <input type="tel" wire:model="phone" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="3001234567">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico *</label>
                    <input type="email" wire:model="email" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="correo@ejemplo.com">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ciudad *</label>
                    <select wire:model="city" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition">
                        <option value="">Selecciona tu ciudad</option>
                        <option value="Cartagena">Cartagena</option>
                        <option value="Barranquilla">Barranquilla</option>
                        <option value="Santa Marta">Santa Marta</option>
                        <option value="Otra">Otra</option>
                    </select>
                    @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex items-center justify-center">
                <div id="recaptcha-container" class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" data-callback="onRecaptchaSuccess"></div>
            </div>
            @error('recaptcha') <span class="text-red-500 text-sm text-center block">{{ $message }}</span> @enderror

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-lg font-bold rounded-xl hover:from-orange-600 hover:to-orange-700 transform hover:scale-105 transition shadow-lg">
                🚀 Solicita tu moto ahora
            </button>
        </form>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onRecaptchaSuccess(token) {
                @this.set('recaptcha', token);
            }

            window.addEventListener('reset-recaptcha', () => {
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
            });
        </script>
    @endif
</div>
