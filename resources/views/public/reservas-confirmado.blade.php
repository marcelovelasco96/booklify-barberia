{{-- resources/views/public/reservas-confirmado.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva confirmada | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-lg w-full bg-white border rounded-lg p-10 text-center space-y-6">

            <div class="text-3xl">🎉</div>

            <h2 class="text-xl font-semibold mb-2">
                Reserva confirmada
            </h2>

            <p class="text-gray-600 mb-4">
                Tu cita en CUSI BARBERSHOP fue confirmada.
            </p>

            @php($code = str_pad($booking->id, 5, '0', STR_PAD_LEFT))

            @if ($booking)
                <div class="mx-auto w-fit rounded-md border border-gray-200 bg-gray-50 px-4 py-2 text-sm text-gray-700">
                    Código de reserva:
                    <span class="font-semibold text-gray-900">#{{ $code }}</span>
                </div>
            @endif

            <p class="mt-3 text-sm text-gray-600">
                Guarda y presenta este código en la barbería.
            </p>

            @if ($booking)
                <div class="text-sm text-gray-700">
                    <div><span class="font-medium">Fecha:</span>
                        {{ \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</div>
                    <div class="mt-1"><span class="font-medium">Hora:</span>
                        {{ \Illuminate\Support\Carbon::parse($booking->booking_time)->format('H:i') }}</div>
                </div>
            @endif

            @php($wa = \App\Support\WhatsAppLink::forBooking($booking))

            @if ($wa)
                <a href="{{ $wa }}" target="_blank"
                    style="display:inline-flex; align-items:center; justify-content:center; padding:12px 18px; border:2px solid #16a34a; color:#16a34a; border-radius:10px; font-weight:600; text-decoration:none; transition:0.2s;"
                    onmouseover="this.style.background='#16a34a'; this.style.color='#ffffff';"
                    onmouseout="this.style.background='transparent'; this.style.color='#16a34a';">
                    Escribir por WhatsApp
                </a>
            @endif

            <p class="text-sm text-gray-500">
                Si tienes alguna consulta adicional, puedes escribirnos por WhatsApp.
                @if (!empty($booking?->email))
                    También te enviamos un correo con los detalles.
                @else
                    Si deseas recibir el detalle por correo, realiza una nueva reserva ingresando tu email.
                @endif
            </p>

            <div class="pt-4">
                <x-public.btn-gold :href="route('public.reservas')">
                    Volver al inicio
                </x-public.btn-gold>
            </div>

        </div>
    </div>

</body>

</html>
