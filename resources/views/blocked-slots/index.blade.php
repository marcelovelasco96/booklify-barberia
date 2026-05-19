<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#0b0f14]">
                Bloqueos de agenda
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Registra fechas u horarios no disponibles para reservas.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-[radial-gradient(circle_at_top,#f8f6ef_0%,#f3f4f6_45%,#eef0f3_100%)] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="rounded-md bg-green-50 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-3xl border border-black/5 bg-white shadow-sm">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-bold tracking-tight text-[#0b0f14]">
                        Registrar bloqueo
                    </h3>

                    <p class="mt-1 mb-6 text-sm text-gray-500">
                        Bloquea días completos o horarios específicos.
                    </p>

                    <form method="POST" action="{{ route('blocked-slots.store') }}"
                        class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Servicio</label>
                            <select name="service_id"
                                class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]">
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
                                class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]">
                            @error('blocked_date')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hora (opcional)</label>
                            <input type="time" name="blocked_time" value="{{ old('blocked_time') }}"
                                class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]">
                            <p class="text-xs text-gray-500 mt-1">Si lo dejas vacío, bloquea todo el día.</p>
                            @error('blocked_time')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Motivo (opcional)</label>
                            <input type="text" name="reason" value="{{ old('reason') }}"
                                class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]"
                                maxlength="255">
                            @error('reason')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-4">
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-xl bg-[#0b0f14] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-black">
                                Guardar bloqueo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-black/5 bg-white shadow-sm">
                <div class="p-6 sm:p-8">
                    <h3 class="text-xl font-bold tracking-tight text-[#0b0f14]">
                        Bloqueos registrados
                    </h3>

                    <p class="mt-1 mb-6 text-sm text-gray-500">
                        Historial de fechas y horarios bloqueados.
                    </p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <tr class="border-b border-gray-100 text-center">
                                    <th class="py-3 pr-4">Servicio</th>
                                    <th class="py-3 pr-4">Fecha</th>
                                    <th class="py-3 pr-4">Hora</th>
                                    <th class="py-3 pr-4">Motivo</th>
                                    <th class="py-3 pr-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800">
                                @forelse ($blockedSlots as $slot)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50/70 transition">
                                        <td class="py-3 pr-4 text-center">{{ $slot->service?->name }}</td>
                                        <td class="py-3 pr-4 text-center">
                                            {{ \Illuminate\Support\Carbon::parse($slot->blocked_date)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 pr-4 text-center">
                                            {{ $slot->blocked_time ? \Illuminate\Support\Carbon::parse($slot->blocked_time)->format('H:i') : 'Todo el día' }}
                                        </td>
                                        <td class="py-3 pr-4 text-center">{{ $slot->reason ?: '—' }}</td>
                                        <td class="py-3 pr-4 text-center">
                                            <form method="POST" action="{{ route('blocked-slots.destroy', $slot) }}"
                                                onsubmit="return confirm('¿Eliminar este bloqueo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100">
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
    </div>
</x-app-layout>
