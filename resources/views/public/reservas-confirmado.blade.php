{{-- resources/views/public/reservas-confirmado.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva confirmada | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-b from-[#f8f8f7] to-[#f1f1ef] text-gray-900">

    @php($code = str_pad($booking->id, 5, '0', STR_PAD_LEFT))
    @php($wa = \App\Support\WhatsAppLink::forBooking($booking))

    <div class="min-h-screen flex items-center justify-center px-4 py-10">

        <div
            class="w-full max-w-xl rounded-3xl border border-black/5 bg-white/95 shadow-[0_20px_60px_rgba(0,0,0,0.08)] backdrop-blur p-8 sm:p-10 text-center">

            {{-- Icono --}}
            <div
                class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#0b0f14] shadow-lg shadow-black/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-[#d4af37]" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            {{-- Título --}}
            <div class="mt-6">
                <h1 class="text-3xl font-bold tracking-tight text-[#0b0f14]">
                    Reserva confirmada
                </h1>

                <p class="mt-3 text-[15px] leading-relaxed text-gray-600">
                    Tu cita en <span class="font-semibold text-[#0b0f14]">CUSI BARBERSHOP</span>
                    fue registrada correctamente.
                </p>

                @if ($booking?->service)
                    <p class="mt-2 text-sm text-gray-500">
                        Servicio:
                        <span class="font-semibold text-[#0b0f14]">
                            {{ $booking->service->name }}
                        </span>
                    </p>
                @endif

                @if ($booking?->barber)
                    <p class="mt-1 text-sm text-gray-500">
                        Barbero:
                        <span class="font-semibold text-[#0b0f14]">
                            {{ $booking->barber->name }}
                        </span>
                    </p>
                @endif
            </div>

            {{-- Código --}}
            @if ($booking)
                <div
                    class="mx-auto mt-6 inline-flex items-center gap-2 rounded-2xl border border-[#d4af37]/20 bg-[#fffaf0] px-5 py-3 text-sm shadow-sm">
                    <span class="text-gray-600">Código de reserva</span>

                    <span class="font-bold tracking-wide text-[#0b0f14]">
                        #{{ $code }}
                    </span>
                </div>
            @endif

            {{-- Texto --}}
            <p class="mt-5 text-sm leading-relaxed text-gray-500">
                Guarda este código y preséntalo en la barbería el día de tu cita.
            </p>

            {{-- Fecha/Hora --}}
            @if ($booking)
                <div class="mt-7 grid grid-cols-2 gap-3">

                    <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-4">
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Fecha
                        </div>

                        <div class="mt-2 text-lg font-bold text-[#0b0f14]">
                            {{ \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200 bg-gray-50 px-4 py-4">
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Hora
                        </div>

                        <div class="mt-2 text-lg font-bold text-[#0b0f14]">
                            {{ \Illuminate\Support\Carbon::parse($booking->booking_time)->format('H:i') }}
                        </div>
                    </div>

                </div>
            @endif

            {{-- WhatsApp --}}
            @if ($wa)
                <div class="mt-8">
                    <a href="{{ $wa }}" target="_blank"
                        class="inline-flex items-center justify-center gap-3 rounded-2xl bg-[#0b0f14] px-6 py-4 text-sm font-semibold text-white shadow-lg shadow-black/10 transition hover:-translate-y-[1px] hover:bg-black">

                        <span class="h-2.5 w-2.5 rounded-full bg-green-400"></span>

                        Escribir por WhatsApp
                    </a>
                </div>
            @endif

            {{-- Texto inferior --}}
            <div class="mt-8 border-t border-gray-100 pt-6">
                <p class="mx-auto max-w-md text-sm leading-relaxed text-gray-500">
                    Si tienes alguna consulta adicional, puedes escribirnos por WhatsApp.

                    @if (!empty($booking?->email))
                        También te enviamos un correo con los detalles.
                    @else
                        Si deseas recibir el detalle por correo, realiza una nueva reserva ingresando tu email.
                    @endif
                </p>
            </div>

            {{-- Botón --}}
            <div class="mt-8">
                <x-public.btn-gold :href="route('public.reservas')">
                    Volver al inicio
                </x-public.btn-gold>
            </div>

        </div>

    </div>

</body>

</html>
