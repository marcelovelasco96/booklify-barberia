<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar bloqueo
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Registrar bloqueo</h3>

                <form method="POST" action="{{ route('blocked-slots.store') }}"
                    class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Servicio</label>
                        <select name="service_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Seleccionar --</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" name="blocked_date" value="{{ old('blocked_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300">
                        @error('blocked_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hora (opcional)</label>
                        <input type="time" name="blocked_time" value="{{ old('blocked_time') }}"
                            class="mt-1 block w-full rounded-md border-gray-300">
                        <p class="text-xs text-gray-500 mt-1">Si lo dejas vacío, bloquea todo el día.</p>
                        @error('blocked_time')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Motivo (opcional)</label>
                        <input type="text" name="reason" value="{{ old('reason') }}"
                            class="mt-1 block w-full rounded-md border-gray-300" maxlength="255">
                        @error('reason')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-4">
                        <button type="submit"
                            class="inline-flex items-center rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                            Guardar bloqueo
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Bloqueos registrados</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-600">
                            <tr class="border-b">
                                <th class="py-2 pr-4">Servicio</th>
                                <th class="py-2 pr-4">Fecha</th>
                                <th class="py-2 pr-4">Hora</th>
                                <th class="py-2 pr-4">Motivo</th>
                                <th class="py-2 pr-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            @forelse ($blockedSlots as $slot)
                                <tr class="border-b">
                                    <td class="py-2 pr-4">{{ $slot->service?->name }}</td>
                                    <td class="py-2 pr-4">
                                        {{ \Illuminate\Support\Carbon::parse($slot->blocked_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $slot->blocked_time ? \Illuminate\Support\Carbon::parse($slot->blocked_time)->format('H:i') : 'Todo el día' }}
                                    </td>
                                    <td class="py-2 pr-4">{{ $slot->reason ?: '—' }}</td>
                                    <td class="py-2 pr-4">
                                        <form method="POST" action="{{ route('blocked-slots.destroy', $slot) }}"
                                            onsubmit="return confirm('¿Eliminar este bloqueo?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-gray-500">No hay bloqueos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $blockedSlots->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
