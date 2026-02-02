<x-app-layout>

    @php
        $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de la reserva #{{ $code }}
        </h2>
    </x-slot>

    <div class="py-8">

        @if (session('success'))
            <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-4">
                    <div>
                        <span class="text-sm text-gray-500">Servicio</span>
                        <p class="font-medium">{{ $booking->service?->name }}</p>
                    </div>

                    <div>
                        <span class="text-sm text-gray-500">Cliente</span>
                        <p class="font-medium">{{ $booking->full_name }}</p>
                    </div>

                    <div>
                        <span class="text-sm text-gray-500">Teléfono</span>
                        <p class="font-medium">{{ $booking->phone }}</p>
                    </div>

                    @if ($booking->email)
                        <div>
                            <span class="text-sm text-gray-500">Email</span>
                            <p class="font-medium">{{ $booking->email }}</p>
                        </div>
                    @endif

                    <div class="flex gap-6">
                        <div>
                            <span class="text-sm text-gray-500">Fecha</span>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Hora</span>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <span class="text-sm text-gray-500">Estado</span>
                        <p class="font-medium">
                            {{ $booking->status === 'confirmed' ? 'Confirmada' : 'Cancelada' }}
                        </p>
                    </div>

                    <div class="pt-2 flex items-center gap-2">
                        <form method="POST" action="{{ route('bookings.updateStatus', $booking) }}">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="redirect_to" value="show">

                            @if ($booking->status === 'confirmed')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit"
                                    class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                                    Cancelar reserva
                                </button>
                            @else
                                <input type="hidden" name="status" value="confirmed">
                                <button type="submit"
                                    class="inline-flex items-center rounded-md bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                                    Reconfirmar reserva
                                </button>
                            @endif
                        </form>

                        <a href="{{ route('bookings.print', $booking) }}" target="_blank"
                            class="inline-flex items-center rounded-md bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-800">
                            Imprimir / PDF
                        </a>

                        @php($wa = \App\Support\WhatsAppLink::toClient($booking))

                        @if ($wa)
                            <a href="{{ $wa }}" target="_blank"
                                class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white hover:bg-green-700">
                                WhatsApp
                            </a>
                        @endif

                    </div>

                    <div class="pt-4">
                        <a href="{{ route('bookings.index') }}"
                            class="inline-flex items-center rounded-md bg-gray-200 px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300">
                            ← Volver al listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
