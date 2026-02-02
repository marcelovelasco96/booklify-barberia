<?php

namespace App\Support;

use App\Models\Booking;
use Illuminate\Support\Carbon;

class WhatsApp
{
    public static function bookingLink(Booking $booking): ?string
    {
        $phone = config('booklify.whatsapp_phone');

        if (empty($phone)) {
            return null;
        }

        $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);
        $date = Carbon::parse($booking->booking_date)->format('d/m/Y');
        $time = Carbon::parse($booking->booking_time)->format('H:i');
        $service = $booking->service?->name;

        $message = "Hola, tengo una reserva confirmada.\n"
            . "Código: #{$code}\n"
            . "Servicio: {$service}\n"
            . "Fecha: {$date} {$time}";

        return 'https://wa.me/' . $phone . '?text=' . urlencode($message);
    }
}
