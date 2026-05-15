<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                Panel administrativo
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Resumen de reservas y próximas citas de CUSI BARBERSHOP.
            </p>
        </div>
    </x-slot>

    <div class="py-8 bg-[radial-gradient(circle_at_top,#f8f6ef_0%,#f3f4f6_45%,#eef0f3_100%)] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-5">

                {{-- Hoy --}}
                <div
                    class="rounded-3xl border border-black/5 bg-white/90 p-5 shadow-[0_10px_30px_rgba(0,0,0,0.05)] backdrop-blur">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Hoy
                            </div>

                            <div class="mt-2 text-4xl font-bold tracking-tight text-[#0b0f14]">
                                {{ $countToday }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-[#0b0f14] p-3 text-xl text-[#d4af37]">
                            📅
                        </div>
                    </div>
                </div>

                {{-- Mañana --}}
                <div
                    class="rounded-3xl border border-black/5 bg-white/90 p-5 shadow-[0_10px_30px_rgba(0,0,0,0.05)] backdrop-blur">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Mañana
                            </div>

                            <div class="mt-2 text-4xl font-bold tracking-tight text-[#0b0f14]">
                                {{ $countTomorrow }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-[#0b0f14] p-3 text-xl text-[#d4af37]">
                            ⏳
                        </div>
                    </div>
                </div>

                {{-- Semana --}}
                <div
                    class="rounded-3xl border border-black/5 bg-white/90 p-5 shadow-[0_10px_30px_rgba(0,0,0,0.05)] backdrop-blur">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Esta semana
                            </div>

                            <div class="mt-2 text-4xl font-bold tracking-tight text-[#0b0f14]">
                                {{ $countThisWeek }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-[#0b0f14] p-3 text-xl text-[#d4af37]">
                            📊
                        </div>
                    </div>
                </div>

                {{-- Confirmadas --}}
                <div
                    class="rounded-3xl border border-green-100 bg-white/90 p-5 shadow-[0_10px_30px_rgba(0,0,0,0.05)] backdrop-blur">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Confirmadas
                            </div>

                            <div class="mt-2 text-4xl font-bold tracking-tight text-green-700">
                                {{ $countConfirmed }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-green-100 p-3 text-xl">
                            ✅
                        </div>
                    </div>
                </div>

                {{-- Canceladas --}}
                <div
                    class="rounded-3xl border border-red-100 bg-white/90 p-5 shadow-[0_10px_30px_rgba(0,0,0,0.05)] backdrop-blur">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-500">
                                Canceladas
                            </div>

                            <div class="mt-2 text-4xl font-bold tracking-tight text-red-600">
                                {{ $countCancelled }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-red-100 p-3 text-xl">
                            ❌
                        </div>
                    </div>
                </div>

            </div>

            <div
                class="rounded-3xl border border-black/5 bg-white/90 px-6 pt-6 pb-3 shadow-[0_10px_30px_rgba(0,0,0,0.05)] backdrop-blur">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold tracking-tight text-[#0b0f14]">
                            Próximas citas
                        </h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Vista rápida de las reservas más cercanas.
                        </p>
                    </div>

                    <a href="{{ route('bookings.index') }}"
                        class="hidden sm:inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50">
                        Ver agenda
                    </a>
                </div>

                <div class="mt-5 overflow-x-auto pb-3">
                    <div class="flex gap-4 min-w-max">
                        @forelse ($nextBookings->take(6) as $b)
                            @php($code = str_pad($b->id, 5, '0', STR_PAD_LEFT))

                            <a href="{{ route('bookings.show', $b) }}"
                                class="w-64 shrink-0 rounded-2xl border border-gray-200 bg-gray-50 p-4 transition hover:-translate-y-1 hover:bg-white hover:shadow-md">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        @php($bookingDate = \Illuminate\Support\Carbon::parse($b->booking_date))

                                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                            @if ($bookingDate->isToday())
                                                Hoy
                                            @elseif ($bookingDate->isTomorrow())
                                                Mañana
                                            @else
                                                {{ $bookingDate->format('d/m/Y') }}
                                            @endif
                                        </div>

                                        <div class="mt-1 text-2xl font-bold text-[#0b0f14]">
                                            {{ \Illuminate\Support\Carbon::parse($b->booking_time)->format('H:i') }}
                                        </div>
                                    </div>

                                    <span
                                        class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                                        Confirmada
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <div class="font-semibold text-gray-900 truncate">
                                        {{ $b->service?->name }}
                                    </div>

                                    <div class="mt-1 text-sm text-gray-500 truncate">
                                        {{ $b->full_name }}
                                    </div>
                                </div>

                                <div class="mt-4 text-xs font-medium text-gray-400">
                                    #{{ $code }}
                                </div>
                            </a>
                        @empty
                            <div class="rounded-2xl border border-gray-200 bg-gray-50 p-5 text-sm text-gray-500">
                                No hay próximas citas registradas.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div
                class="rounded-3xl border border-black/5 bg-white/90 p-7 shadow-[0_10px_30px_rgba(0,0,0,0.05)] backdrop-blur">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-2xl font-bold tracking-tight text-[#0b0f14]">
                            Actividad reciente
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Últimas reservas registradas en el sistema.
                        </p>
                    </div>
                    <a href="{{ route('bookings.index') }}"
                        class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50">
                        Ver todas
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                            <tr class="border-b">
                                <th class="py-2 pr-4 text-center">Código</th>
                                <th class="py-2 pr-4 text-center">Servicio</th>
                                <th class="py-2 pr-4 text-center">Cliente</th>
                                <th class="py-2 pr-4 text-center">Fecha</th>
                                <th class="py-2 pr-4 text-center">Hora</th>
                                <th class="py-2 pr-4 text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            @forelse ($nextBookings->sortByDesc('created_at') as $b)
                                @php($code = str_pad($b->id, 5, '0', STR_PAD_LEFT))
                                <tr class="border-b border-gray-100 hover:bg-gray-50/70 transition">
                                    <td class="py-3 pr-4 text-center">
                                        <a class="hover:underline" href="{{ route('bookings.show', $b) }}">
                                            {{ $code }}
                                        </a>
                                    </td>
                                    <td class="py-3 pr-4 text-center">{{ $b->service?->name }}</td>
                                    <td class="py-3 pr-4 text-center">{{ $b->full_name }}</td>
                                    <td class="py-3 pr-4 text-center">
                                        {{ \Illuminate\Support\Carbon::parse($b->booking_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="py-3 pr-4 text-center">
                                        {{ \Illuminate\Support\Carbon::parse($b->booking_time)->format('H:i') }}
                                    </td>
                                    <td class="py-3 pr-4 text-center">
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
