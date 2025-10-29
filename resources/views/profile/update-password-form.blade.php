<div class="p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-2">Actualizar Contraseña</h3>
    <p class="text-sm text-gray-600 mb-6">Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerse segura.</p>

    <form wire:submit.prevent="updatePassword">
        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Contraseña Actual</label>
                <input type="password" wire:model="state.current_password" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="••••••••">
                @error('current_password') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nueva Contraseña</label>
                <input type="password" wire:model="state.password" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="••••••••">
                @error('password') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Confirmar Contraseña</label>
                <input type="password" wire:model="state.password_confirmation" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="••••••••">
                @error('password_confirmation') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <div wire:loading.remove wire:target="updatePassword">
                @if (session()->has('saved'))
                <span class="text-sm text-green-600 font-medium">✓ Guardado</span>
                @endif
            </div>
            <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl hover:from-orange-700 hover:to-orange-800 transition font-medium shadow-lg">
                Actualizar Contraseña
            </button>
        </div>
    </form>
</div>
