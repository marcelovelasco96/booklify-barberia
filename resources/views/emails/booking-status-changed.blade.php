@php($code = str_pad($booking->id, 5, '0', STR_PAD_LEFT))
@php($statusText = $booking->status === 'confirmed' ? 'confirmada' : 'cancelada')
@php($wa = \App\Support\WhatsAppLink::forBooking($booking, 'client'))

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reserva #{{ $code }} {{ $statusText }}</title>
</head>

<body style="font-family: Arial, sans-serif; color:#111; line-height: 1.4;">
    <div style="max-width: 640px; margin: 0 auto; padding: 24px;">
        <h2 style="margin: 0 0 8px;">Tu reserva fue {{ $statusText }}</h2>

        <p style="margin: 0 0 16px; color:#555;">
            Código de reserva: <strong>#{{ $code }}</strong>
        </p>

        <div style="border:1px solid #ddd; border-radius: 10px; padding: 16px;">
            <p style="margin: 0 0 8px;"><strong>Servicio:</strong> {{ $booking->service?->name }}</p>
            <p style="margin: 0 0 8px;"><strong>Cliente:</strong> {{ $booking->full_name }}</p>
            <p style="margin: 0 0 8px;"><strong>Teléfono:</strong> {{ $booking->phone }}</p>
            <p style="margin: 0 0 8px;"><strong>Fecha:</strong>
                {{ \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</p>
            <p style="margin: 0;"><strong>Hora:</strong>
                {{ \Illuminate\Support\Carbon::parse($booking->booking_time)->format('H:i') }}</p>
        </div>

        @if ($wa)
            <p style="margin: 16px 0 0;">
                <a href="{{ $wa }}" target="_blank"
                    style="display:inline-block; background:#16a34a; color:#fff; text-decoration:none; padding:10px 14px; border-radius:8px; font-weight:600;">
                    Escribir por WhatsApp
                </a>
            </p>
        @endif

        <p style="margin: 16px 0 0; color:#777; font-size: 12px;">
            Si crees que esto es un error, por favor contáctanos.
        </p>
    </div>
</body>

</html>
