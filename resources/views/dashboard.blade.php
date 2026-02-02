<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Panel
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Hoy</div>
                    <div class="text-3xl font-bold mt-1">{{ $countToday }}</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Mañana</div>
                    <div class="text-3xl font-bold mt-1">{{ $countTomorrow }}</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Esta semana</div>
                    <div class="text-3xl font-bold mt-1">{{ $countThisWeek }}</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Confirmadas</div>
                    <div class="text-3xl font-bold mt-1">{{ $countConfirmed }}</div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-5">
                    <div class="text-sm text-gray-500">Canceladas</div>
                    <div class="text-3xl font-bold mt-1">{{ $countCancelled }}</div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">Próximas reservas</h3>
                    <a href="{{ route('bookings.index') }}" class="text-sm text-gray-700 hover:underline">
                        Ver todas
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-gray-600">
                            <tr class="border-b">
                                <th class="py-2 pr-4">Código</th>
                                <th class="py-2 pr-4">Servicio</th>
                                <th class="py-2 pr-4">Cliente</th>
                                <th class="py-2 pr-4">Fecha</th>
                                <th class="py-2 pr-4">Hora</th>
                                <th class="py-2 pr-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            @forelse ($nextBookings as $b)
                                @php($code = str_pad($b->id, 5, '0', STR_PAD_LEFT))
                                <tr class="border-b">
                                    <td class="py-2 pr-4">
                                        <a class="hover:underline" href="{{ route('bookings.show', $b) }}">
                                            #{{ $code }}
                                        </a>
                                    </td>
                                    <td class="py-2 pr-4">{{ $b->service?->name }}</td>
                                    <td class="py-2 pr-4">{{ $b->full_name }}</td>
                                    <td class="py-2 pr-4">
                                        {{ \Illuminate\Support\Carbon::parse($b->booking_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ \Illuminate\Support\Carbon::parse($b->booking_time)->format('H:i') }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        <span
                                            class="inline-flex items-center rounded-full px-2 py-1 text-xs font-semibold
                                            {{ $b->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $b->status === 'confirmed' ? 'Confirmada' : 'Cancelada' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-gray-500">No hay reservas próximas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
