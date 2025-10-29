<div class="p-6">
    <h3 class="text-xl font-bold text-gray-900 mb-2">Información del Perfil</h3>
    <p class="text-sm text-gray-600 mb-6">Actualiza la información de tu cuenta y dirección de correo electrónico.</p>

    <form wire:submit.prevent="updateProfileInformation">
        <div class="space-y-6">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}">
                <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                    x-on:change="photoName = $refs.photo.files[0].name; const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL($refs.photo.files[0]);" />

                <label class="block text-sm font-semibold text-gray-700 mb-2">Foto de Perfil</label>

                <div class="flex items-center gap-4">
                    <div x-show="! photoPreview">
                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" class="rounded-full h-20 w-20 object-cover border-4 border-orange-100">
                    </div>
                    <div x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center border-4 border-orange-100" x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" x-on:click.prevent="$refs.photo.click()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                            Seleccionar Foto
                        </button>
                        @if ($this->user->profile_photo_path)
                        <button type="button" wire:click="deleteProfilePhoto" class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                            Eliminar
                        </button>
                        @endif
                    </div>
                </div>
                @error('photo') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
            </div>
            @endif

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre Completo</label>
                <input type="text" wire:model="state.name" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="Tu nombre completo">
                @error('name') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Correo Electrónico</label>
                <input type="email" wire:model="state.email" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition" placeholder="tu@email.com">
                @error('email') <span class="text-red-500 text-sm mt-2">{{ $message }}</span> @enderror

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        Tu correo electrónico no está verificado.
                        <button type="button" wire:click.prevent="sendEmailVerification" class="underline font-medium hover:text-yellow-900">
                            Haz clic aquí para reenviar el correo de verificación.
                        </button>
                    </p>
                    @if ($this->verificationLinkSent)
                    <p class="mt-2 text-sm text-green-600 font-medium">
                        Se ha enviado un nuevo enlace de verificación a tu correo.
                    </p>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <div wire:loading.remove wire:target="updateProfileInformation">
                @if (session()->has('saved'))
                <span class="text-sm text-green-600 font-medium">✓ Guardado</span>
                @endif
            </div>
            <button type="submit" wire:loading.attr="disabled" class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl hover:from-orange-700 hover:to-orange-800 transition font-medium shadow-lg">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
