<div class="p-6">
    @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('message') }}</div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="text-gray-500 text-sm">Total</div>
            <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow p-4">
            <div class="text-yellow-700 text-sm">Pendientes</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-blue-50 rounded-lg shadow p-4">
            <div class="text-blue-700 text-sm">En Estudio</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['in_study'] }}</div>
        </div>
        <div class="bg-green-50 rounded-lg shadow p-4">
            <div class="text-green-700 text-sm">Aprobados</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
        </div>
        <div class="bg-red-50 rounded-lg shadow p-4">
            <div class="text-red-700 text-sm">Rechazados</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <input wire:model.live="search" type="text" placeholder="Buscar..." class="px-4 py-2 border rounded-lg">
            <select wire:model.live="statusFilter" class="px-4 py-2 border rounded-lg">
                <option value="">Todos los estados</option>
                <option value="pending">Pendiente</option>
                <option value="in_study">En Estudio</option>
                <option value="approved">Aprobado</option>
                <option value="rejected">Rechazado</option>
            </select>
            <select wire:model.live="cityFilter" class="px-4 py-2 border rounded-lg">
                <option value="">Todas las ciudades</option>
                <option value="Cartagena">Cartagena</option>
                <option value="Barranquilla">Barranquilla</option>
                <option value="Santa Marta">Santa Marta</option>
            </select>
            <input wire:model.live="dateFrom" type="date" class="px-4 py-2 border rounded-lg">
            <input wire:model.live="dateTo" type="date" class="px-4 py-2 border rounded-lg">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cédula</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ciudad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asesor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($applications as $app)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $app->full_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $app->document_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $app->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $app->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $app->city }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full bg-{{ $app->status_color }}-100 text-{{ $app->status_color }}-800">
                            {{ $app->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $app->assignedAdvisor->name ?? 'Sin asignar' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $app->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-3">
                            <button wire:click="edit({{ $app->id }})" class="text-blue-600 hover:text-blue-900">Editar</button>
                            <a href="{{ route('clients.create-from-application', $app->id) }}" class="text-green-600 hover:text-green-900">Crear Cliente</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-4">
            {{ $applications->links() }}
        </div>
    </div>

    <!-- Edit Modal -->
    @if($showEditModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-bold mb-4">Editar Solicitud</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Estado</label>
                    <select wire:model="newStatus" class="w-full px-3 py-2 border rounded-lg">
                        <option value="pending">Pendiente</option>
                        <option value="in_study">En Estudio</option>
                        <option value="approved">Aprobado</option>
                        <option value="rejected">Rechazado</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Asesor</label>
                    <select wire:model="newAdvisor" class="w-full px-3 py-2 border rounded-lg">
                        <option value="">Sin asignar</option>
                        @foreach($advisors as $advisor)
                        <option value="{{ $advisor->id }}">{{ $advisor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Observaciones</label>
                    <textarea wire:model="newObservations" class="w-full px-3 py-2 border rounded-lg" rows="3"></textarea>
                </div>
            </div>
            <div class="flex gap-2 mt-6">
                <button wire:click="update" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Guardar</button>
                <button wire:click="$set('showEditModal', false)" class="flex-1 bg-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400">Cancelar</button>
            </div>
        </div>
    </div>
    @endif
</div>
