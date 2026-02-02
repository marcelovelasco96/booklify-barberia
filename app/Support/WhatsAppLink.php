<?php

namespace App\Support;

use App\Models\Booking;

class WhatsAppLink
{
    public static function forBooking(Booking $booking, string $context = 'client'): ?string
    {
        $phone = config('booklify.whatsapp_phone');

        if (empty($phone)) {
            return null;
        }

        $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);

        $service = $booking->service?->name ?? 'Servicio';
        $date = \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y');
        $time = \Illuminate\Support\Carbon::parse($booking->booking_time)->format('H:i');

        if ($context === 'admin') {
            $text = "Hola, necesito atender la reserva #{$code}.\n"
                . "Cliente: {$booking->full_name}\n"
                . "Servicio: {$service}\n"
                . "Fecha: {$date}\n"
                . "Hora: {$time}\n";
        } else {
            $text = "Hola, tengo una consulta sobre mi reserva #{$code}.\n"
                . "Servicio: {$service}\n"
                . "Fecha: {$date}\n"
                . "Hora: {$time}\n";
        }

        return 'https://wa.me/' . $phone . '?text=' . urlencode($text);
    }

    public static function toClient(Booking $booking): ?string
    {
        $raw = $booking->phone ?? '';
        $digits = preg_replace('/\D+/', '', $raw);

        if (empty($digits)) {
            return null;
        }

        // Si el número parece peruano sin código país (9 dígitos), anteponemos 51
        if (strlen($digits) === 9) {
            $digits = '51' . $digits;
        }

        // Si viene con 0 adelante (ej. 0987...), lo limpiamos de forma conservadora
        if (strlen($digits) === 10 && str_starts_with($digits, '0')) {
            $digits = ltrim($digits, '0');
            if (strlen($digits) === 9) {
                $digits = '51' . $digits;
            }
        }

        $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);
        $service = $booking->service?->name ?? 'Servicio';
        $date = \Illuminate\Support\Carbon::parse($booking->booking_date)->format('d/m/Y');
        $time = \Illuminate\Support\Carbon::parse($booking->booking_time)->format('H:i');

        $text = "Hola {$booking->full_name}, te escribo por tu reserva #{$code}.\n"
            . "Servicio: {$service}\n"
            . "Fecha: {$date}\n"
            . "Hora: {$time}\n";

        return 'https://wa.me/' . $digits . '?text=' . urlencode($text);
    }
}
