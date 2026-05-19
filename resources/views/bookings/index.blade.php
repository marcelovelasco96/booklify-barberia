<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservas
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-black/5 bg-white shadow-sm">
                <div class="p-6 sm:p-8">

                    @if (session('success'))
                        <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="GET" action="{{ route('bookings.index') }}"
                        class="mb-6 flex flex-wrap items-center gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4">
                        <label class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                            Filtrar
                        </label>

                        <select name="status"
                            class="rounded-xl border-gray-200 bg-white pl-4 pr-10 py-2.5 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]"
                            onchange="this.form.submit()">
                            <option value="">Cualquier estado</option>
                            <option value="confirmed" @selected(request('status') === 'confirmed')>Confirmadas</option>
                            <option value="cancelled" @selected(request('status') === 'cancelled')>Canceladas</option>
                        </select>

                        <select name="service_id"
                            class="rounded-xl border-gray-200 bg-white pl-4 pr-10 py-2.5 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]"
                            onchange="this.form.submit()">
                            <option value="">Todos los servicios</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected((string) request('service_id') === (string) $service->id)>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </select>

                        <select name="barber_id"
                            class="rounded-xl border-gray-200 bg-white pl-4 pr-10 py-2.5 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]"
                            onchange="this.form.submit()">
                            <option value="">Todos los barberos</option>

                            @foreach ($barbers as $barber)
                                <option value="{{ $barber->id }}" @selected((string) request('barber_id') === (string) $barber->id)>
                                    {{ $barber->name }}
                                </option>
                            @endforeach
                        </select>

                        <input type="date" name="date" value="{{ request('date') }}"
                            class="rounded-xl border-gray-200 bg-white px-4 py-2.5 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]"
                            onchange="this.form.submit()">

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
                                <thead class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr class="border-b border-gray-100 text-center">
                                        <th class="py-3 pr-4">#</th>
                                        <th class="py-3 pr-4">Servicio</th>
                                        <th class="py-3 pr-4">
                                            Barbero
                                        </th>
                                        <th class="py-3 pr-4">Cliente</th>
                                        <th class="py-3 pr-4">Teléfono</th>
                                        <th class="py-3 pr-4">Fecha</th>
                                        <th class="py-3 pr-4">Hora</th>
                                        <th class="py-3 pr-4">Estado</th>
                                        <th class="py-3 pr-4">Creado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr class="border-b border-gray-100 hover:bg-gray-50/70 transition">
                                            @php
                                                $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);
                                            @endphp

                                            <td class="py-2 pr-4 text-center">
                                                <a href="{{ route('bookings.show', $booking) }}"
                                                    class="font-semibold text-[#0b0f14] hover:underline">
                                                    {{ $code }}
                                                </a>
                                            </td>
                                            <td class="py-2 pr-4 text-center">
                                                {{ $booking->service?->name }}
                                            </td>
                                            <td class="py-2 pr-4 text-center">
                                                @if ($booking->barber)
                                                    <div>
                                                        {{ $booking->barber->name }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-400">—</span>
                                                @endif
                                            </td>
                                            <td class="py-2 pr-4 text-center">{{ $booking->full_name }}</td>
                                            <td class="py-2 pr-4 text-center">{{ $booking->phone }}</td>
                                            <td class="py-2 pr-4 text-center">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="py-2 pr-4 text-center">
                                                {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                                            </td>
                                            <td class="py-2 pr-4 text-center">
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
                                                        class="rounded-full border px-4 py-2 pr-10 text-xs font-semibold shadow-sm transition
                                                                focus:ring-2 focus:ring-offset-0
                                                                {{ $booking->status === 'confirmed'
                                                                    ? 'border-green-200 bg-green-50 text-green-700 focus:ring-green-200'
                                                                    : 'border-red-200 bg-red-50 text-red-700 focus:ring-red-200' }}"
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
                                            <td class="py-2 pr-4 text-center">
                                                {{ $booking->created_at?->format('d/m/Y H:i') }}</td>
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
