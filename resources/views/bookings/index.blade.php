<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservas
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if (session('success'))
                        <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('bookings.index') }}" class="mb-4 flex items-center gap-2">
                        <label class="text-sm text-gray-700">Filtrar:</label>

                        <select name="status" class="rounded border-gray-300 text-sm" onchange="this.form.submit()">
                            <option value="">Cualquier estado</option>
                            <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmadas</option>
                            <option value="cancelled" @selected(request('status') === 'cancelled')>Canceladas</option>
                        </select>

                        <select name="service_id" class="rounded border-gray-300 text-sm" onchange="this.form.submit()">
                            <option value="">Todos los servicios</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected((string) request('service_id') === (string) $service->id)>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="date" name="date" value="{{ request('date') }}"
                            class="rounded border-gray-300 text-sm" onchange="this.form.submit()">

                        <a href="{{ route('bookings.index', array_merge(request()->except('page'), ['date' => now()->toDateString()])) }}"
                            class="rounded bg-gray-100 px-3 py-2 text-sm text-gray-800 hover:bg-gray-200">
                            Hoy
                        </a>

                        <a href="{{ route('bookings.index', array_merge(request()->except('page'), ['date' => now()->addDay()->toDateString()])) }}"
                            class="rounded bg-gray-100 px-3 py-2 text-sm text-gray-800 hover:bg-gray-200">
                            Mañana
                        </a>

                        <a href="{{ route(
                            'bookings.index',
                            array_merge(request()->except('page'), [
                                'from' => now()->toDateString(),
                                'to' => now()->endOfWeek()->toDateString(),
                                'date' => null,
                            ]),
                        ) }}"
                            class="rounded bg-gray-100 px-3 py-2 text-sm text-gray-800 hover:bg-gray-200">
                            Esta semana
                        </a>

                    </form>

                    @if ($bookings->count() === 0)
                        <p class="text-sm text-gray-600">No hay reservas para los filtros seleccionados.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-left border-b">
                                        <th class="py-2 pr-4">#</th>
                                        <th class="py-2 pr-4">Servicio</th>
                                        <th class="py-2 pr-4">Cliente</th>
                                        <th class="py-2 pr-4">Teléfono</th>
                                        <th class="py-2 pr-4">Fecha</th>
                                        <th class="py-2 pr-4">Hora</th>
                                        <th class="py-2 pr-4">Estado</th>
                                        <th class="py-2 pr-4">Creado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr class="border-b">
                                            @php
                                                $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);
                                            @endphp

                                            <td class="py-2 pr-4">
                                                <a href="{{ route('bookings.show', $booking) }}"
                                                    class="text-indigo-600 hover:underline">
                                                    {{ $code }}
                                                </a>
                                            </td>
                                            <td class="py-2 pr-4">{{ $booking->service?->name }}</td>
                                            <td class="py-2 pr-4">{{ $booking->full_name }}</td>
                                            <td class="py-2 pr-4">{{ $booking->phone }}</td>
                                            <td class="py-2 pr-4">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="py-2 pr-4">
                                                {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                                            </td>
                                            <td class="py-2 pr-4">
                                                <form method="POST"
                                                    action="{{ route('bookings.updateStatus', $booking) }}">
                                                    @csrf
                                                    @method('PATCH')

                                                    @php
                                                        $statusClasses = match ($booking->status) {
                                                            'confirmed'
                                                                => 'bg-green-100 text-green-800 border-green-200',
                                                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                                            default
                                                                => 'bg-yellow-100 text-yellow-800 border-yellow-200', // pending u otros
                                                        };
                                                    @endphp

                                                    <select name="status"
                                                        class="rounded-full px-4 py-1 pr-8 text-xs font-medium leading-5 border
                                                        {{ $booking->status === 'confirmed'
                                                            ? 'bg-green-100 text-green-800 border-green-200'
                                                            : 'bg-red-100 text-red-800 border-red-200' }}"
                                                        onchange="this.form.submit()">

                                                        <option value="confirmed" @selected($booking->status === 'confirmed')>
                                                            Confirmada
                                                        </option>
                                                        <option value="cancelled" @selected($booking->status === 'cancelled')>
                                                            Cancelada
                                                        </option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="py-2 pr-4">{{ $booking->created_at?->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
