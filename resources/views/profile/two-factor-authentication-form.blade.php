<div class="p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-2">Autenticación de Dos Factores</h3>
    <p class="text-sm text-gray-600 mb-6">Agrega seguridad adicional a tu cuenta usando autenticación de dos factores.</p>

    <div class="space-y-6">
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <h4 class="text-lg font-semibold text-blue-900 mb-2">
                @if ($this->enabled)
                    @if ($showingConfirmation)
                        🔐 Finaliza la habilitación de la autenticación de dos factores
                    @else
                        ✅ Has habilitado la autenticación de dos factores
                    @endif
                @else
                    ⚠️ No has habilitado la autenticación de dos factores
                @endif
            </h4>
            <p class="text-sm text-blue-800">
                Cuando la autenticación de dos factores está habilitada, se te pedirá un token seguro y aleatorio durante la autenticación. Puedes obtener este token desde la aplicación Google Authenticator de tu teléfono.
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="p-4 bg-white border-2 border-orange-200 rounded-xl">
                    <p class="text-sm font-semibold text-gray-700 mb-4">
                        @if ($showingConfirmation)
                            Para finalizar la habilitación, escanea el siguiente código QR usando la aplicación de autenticación de tu teléfono o ingresa la clave de configuración y proporciona el código OTP generado.
                        @else
                            La autenticación de dos factores está habilitada. Escanea el siguiente código QR usando la aplicación de autenticación de tu teléfono.
                        @endif
                    </p>

                    <div class="flex justify-center p-4 bg-white border border-gray-200 rounded-lg inline-block">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>

                    <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                        <p class="text-sm font-semibold text-gray-700">
                            Clave de Configuración: <span class="font-mono text-orange-600">{{ decrypt($this->user->two_factor_secret) }}</span>
                        </p>
                    </div>

                    @if ($showingConfirmation)
                        <div class="mt-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Código de Verificación</label>
                            <input type="text" wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication" inputmode="numeric" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="123456">
                            @error('code') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>
            @endif

            @if ($showingRecoveryCodes)
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                    <p class="text-sm font-semibold text-yellow-900 mb-4">
                        ⚠️ Guarda estos códigos de recuperación en un administrador de contraseñas seguro. Pueden usarse para recuperar el acceso a tu cuenta si pierdes tu dispositivo de autenticación de dos factores.
                    </p>
                    <div class="grid gap-2 p-4 bg-white border border-yellow-300 rounded-lg font-mono text-sm">
                        @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                            <div class="p-2 bg-gray-50 rounded">{{ $code }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <div class="flex gap-3">
            @if (! $this->enabled)
                <x-confirms-password wire:then="enableTwoFactorAuthentication">
                    <button type="button" wire:loading.attr="disabled" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition font-medium shadow-lg">
                        Habilitar 2FA
                    </button>
                </x-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-confirms-password wire:then="regenerateRecoveryCodes">
                        <button type="button" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium">
                            Regenerar Códigos
                        </button>
                    </x-confirms-password>
                @elseif ($showingConfirmation)
                    <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl hover:from-orange-700 hover:to-orange-800 transition font-medium shadow-lg">
                            Confirmar
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="showRecoveryCodes">
                        <button type="button" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium">
                            Mostrar Códigos de Recuperación
                        </button>
                    </x-confirms-password>
                @endif

                @if ($showingConfirmation)
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-medium">
                            Cancelar
                        </button>
                    </x-confirms-password>
                @else
                    <x-confirms-password wire:then="disableTwoFactorAuthentication">
                        <button type="button" wire:loading.attr="disabled" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition font-medium shadow-lg">
                            Deshabilitar 2FA
                        </button>
                    </x-confirms-password>
                @endif
            @endif
        </div>
    </div>
</div>
