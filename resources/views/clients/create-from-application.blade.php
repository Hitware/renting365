<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Cliente desde Solicitud
            </h2>
            <a href="{{ route('credit-applications.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Volver a Solicitudes
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-bold text-blue-900 mb-2">Información de la Solicitud</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="text-blue-700 font-medium">Nombre:</span>
                        <p class="text-blue-900">{{ $application->full_name }}</p>
                    </div>
                    <div>
                        <span class="text-blue-700 font-medium">Cédula:</span>
                        <p class="text-blue-900">{{ $application->document_number }}</p>
                    </div>
                    <div>
                        <span class="text-blue-700 font-medium">Teléfono:</span>
                        <p class="text-blue-900">{{ $application->phone }}</p>
                    </div>
                    <div>
                        <span class="text-blue-700 font-medium">Email:</span>
                        <p class="text-blue-900">{{ $application->email }}</p>
                    </div>
                </div>
            </div>

            @livewire('clients.client-form', ['application' => $application])
        </div>
    </div>
</x-app-layout>
