<x-app-layout>

    @php
        $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);
        $wa = \App\Support\WhatsAppLink::toClient($booking);
        $isConfirmed = $booking->status === 'confirmed';
    @endphp

    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-[#0b0f14]">
                    Reserva #{{ $code }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Detalle completo de la cita registrada.
                </p>
            </div>

            <a href="{{ route('bookings.index') }}"
                class="inline-flex items-center rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50">
                Volver a Reservas
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-[radial-gradient(circle_at_top,#f8f6ef_0%,#f3f4f6_45%,#eef0f3_100%)] min-h-screen">

        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Resumen principal --}}
                <div class="lg:col-span-2 rounded-3xl border border-black/5 bg-white/95 p-8 shadow-sm">

                    <div class="flex items-start justify-between gap-4 border-b border-gray-100 pb-6">
                        <div>
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Servicio
                            </div>

                            <h3 class="mt-2 text-2xl font-bold tracking-tight text-[#0b0f14]">
                                {{ $booking->service?->name ?? 'Servicio no disponible' }}
                            </h3>

                            @if ($booking->barber)
                                <p class="mt-2 text-sm text-gray-500">
                                    Barbero:
                                    <span class="font-semibold text-[#0b0f14]">
                                        {{ $booking->barber->name }}
                                    </span>
                                </p>
                            @endif
                        </div>

                        <span
                            class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold
                            {{ $isConfirmed ? 'border-green-200 bg-green-50 text-green-700' : 'border-red-200 bg-red-50 text-red-700' }}">
                            {{ $isConfirmed ? 'Confirmada' : 'Cancelada' }}
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-2xl bg-gray-50 p-5">
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Fecha
                            </div>
                            <div class="mt-2 text-xl font-bold text-[#0b0f14]">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                            </div>
                        </div>

                        <div class="rounded-2xl bg-gray-50 p-5">
                            <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                Hora
                            </div>
                            <div class="mt-2 text-xl font-bold text-[#0b0f14]">
                                {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-gray-100 bg-white p-5">
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Cliente
                        </div>

                        <div class="mt-3 space-y-2">
                            <div class="text-lg font-bold text-[#0b0f14]">
                                {{ $booking->full_name }}
                            </div>

                            <div class="text-sm text-gray-600">
                                {{ $booking->phone }}
                            </div>

                            @if ($booking->email)
                                <div class="text-sm text-gray-600">
                                    {{ $booking->email }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Acciones --}}
                <div class="rounded-3xl border border-black/5 bg-[#0b0f14] p-6 text-white shadow-sm">
                    <div class="text-sm text-white/60">
                        Código de reserva
                    </div>

                    <div class="mt-2 text-3xl font-bold tracking-tight">
                        #{{ $code }}
                    </div>

                    <p class="mt-4 text-sm leading-relaxed text-white/60">
                        Usa este panel para contactar al cliente, imprimir el comprobante o actualizar el estado.
                    </p>

                    <div class="mt-6 space-y-3">

                        @if ($wa)
                            <a href="{{ $wa }}" target="_blank"
                                class="inline-flex w-full items-center justify-center rounded-xl bg-green-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-green-600">
                                WhatsApp
                            </a>
                        @endif

                        <a href="{{ route('bookings.print', $booking) }}" target="_blank"
                            class="inline-flex w-full items-center justify-center rounded-xl bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/15">
                            Imprimir / PDF
                        </a>

                        <form method="POST" action="{{ route('bookings.updateStatus', $booking) }}">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="redirect_to" value="show">

                            @if ($isConfirmed)
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-red-500 px-4 py-3 text-sm font-semibold text-white transition hover:bg-red-600">
                                    Cancelar reserva
                                </button>
                            @else
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-[#c9a227] px-4 py-3 text-sm font-semibold text-[#0b0f14] transition hover:bg-[#d4af37]">
                                    Reconfirmar reserva
                                </button>
                            @endif
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
