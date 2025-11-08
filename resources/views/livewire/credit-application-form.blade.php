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
                    <input type="text" id="full_name" wire:model="full_name"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                           placeholder="Juan Pérez"
                           maxlength="255"
                           oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')">
                    @error('full_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Cédula *</label>
                    <input type="text" id="document_number" wire:model.blur="document_number"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                           placeholder="1234567890"
                           maxlength="15"
                           inputmode="numeric"
                           oninput="this.value = this.value.replace(/\D/g, '')">
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono Celular *</label>
                    <input type="tel" id="phone" wire:model="phone"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                           placeholder="3001234567"
                           maxlength="10"
                           inputmode="numeric"
                           oninput="this.value = this.value.replace(/\D/g, '')">
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <p class="text-xs text-gray-500 mt-1">Ingresa tu número de celular (10 dígitos, debe iniciar con 3)</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico *</label>
                    <input type="email" id="email" wire:model="email"
                           class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition"
                           placeholder="correo@ejemplo.com"
                           maxlength="255"
                           autocomplete="email">
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

            <div class="flex items-center justify-center" wire:ignore>
                <div id="recaptcha-container" class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" data-callback="onRecaptchaSuccess" data-expired-callback="onRecaptchaExpired"></div>
            </div>
            @error('recaptcha') <span class="text-red-500 text-sm text-center block mt-1">{{ $message }}</span> @enderror

            <!-- Campo oculto para almacenar el token -->
            <input type="hidden" id="recaptcha-token" wire:model="recaptcha">

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-lg font-bold rounded-xl hover:from-orange-600 hover:to-orange-700 transform hover:scale-105 transition shadow-lg mt-4">
                🚀 Solicita tu moto ahora
            </button>
        </form>

        <style>
            /* Estilos para asegurar que el reCAPTCHA sea visible */
            #recaptcha-container {
                min-height: 78px;
                overflow: visible !important;
            }

           

            .g-recaptcha {
                transform: scale(1);
                transform-origin: 0 0;
            }
        </style>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function onRecaptchaSuccess(token) {
                console.log('✅ reCAPTCHA completado:', token.substring(0, 20) + '...');

                // Actualizar el campo oculto
                const hiddenInput = document.getElementById('recaptcha-token');
                if (hiddenInput) {
                    hiddenInput.value = token;
                    hiddenInput.dispatchEvent(new Event('input'));
                }

                // Sincronizar con Livewire usando múltiples métodos
                if (typeof @this !== 'undefined') {
                    @this.set('recaptcha', token);
                    console.log('✅ Token sincronizado con Livewire');
                }
            }

            function onRecaptchaExpired() {
                console.log('⚠️ reCAPTCHA expirado');

                // Limpiar el campo oculto
                const hiddenInput = document.getElementById('recaptcha-token');
                if (hiddenInput) {
                    hiddenInput.value = '';
                    hiddenInput.dispatchEvent(new Event('input'));
                }

                // Limpiar en Livewire
                if (typeof @this !== 'undefined') {
                    @this.set('recaptcha', '');
                }

                // Resetear reCAPTCHA
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
            }

            // Escuchar evento de reset desde el componente Livewire
            window.addEventListener('reset-recaptcha', () => {
                console.log('🔄 Reseteando reCAPTCHA desde Livewire');
                if (typeof grecaptcha !== 'undefined') {
                    grecaptcha.reset();
                }
                // Limpiar campo oculto
                const hiddenInput = document.getElementById('recaptcha-token');
                if (hiddenInput) {
                    hiddenInput.value = '';
                }
            });

            // Asegurar que el reCAPTCHA esté visible después de cargarse
            document.addEventListener('DOMContentLoaded', function() {
                const checkRecaptcha = setInterval(function() {
                    const recaptchaFrame = document.querySelector('#recaptcha-container iframe');
                    if (recaptchaFrame) {
                        recaptchaFrame.style.visibility = 'visible';
                        recaptchaFrame.style.display = 'block';
                        console.log('✅ reCAPTCHA cargado y visible');
                        clearInterval(checkRecaptcha);
                    }
                }, 100);

                // Timeout de seguridad
                setTimeout(() => clearInterval(checkRecaptcha), 10000);
            });
        </script>
    @endif
</div>
