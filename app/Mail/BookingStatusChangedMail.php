<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusChangedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->booking->loadMissing('service');
    }

    public function envelope(): Envelope
    {
        $code = str_pad($this->booking->id, 5, '0', STR_PAD_LEFT);

        $statusText = $this->booking->status === 'confirmed'
            ? 'confirmada'
            : 'cancelada';

        return new Envelope(
            subject: "Reserva #{$code} {$statusText}"
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-status-changed',
            with: [
                'booking' => $this->booking,
            ]
        );
    }
}
