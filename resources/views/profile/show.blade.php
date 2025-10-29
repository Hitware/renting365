<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Mi Perfil
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            <div class="bg-white rounded-lg shadow-sm">
                @livewire('profile.update-profile-information-form')
            </div>
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            <div class="bg-white rounded-lg shadow-sm">
                @livewire('profile.update-password-form')
            </div>
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            <div class="bg-white rounded-lg shadow-sm">
                @livewire('profile.two-factor-authentication-form')
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm">
            @livewire('profile.logout-other-browser-sessions-form')
        </div>

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <div class="bg-white rounded-lg shadow-sm">
                @livewire('profile.delete-user-form')
            </div>
        @endif
    </div>
</x-app-layout>
