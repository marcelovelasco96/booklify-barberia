<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Mail\BookingStatusChangedMail;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $status = request('status');
        $serviceId = request('service_id');
        $barberId = request('barber_id');
        $date = request('date');
        $from = request('from');
        $to   = request('to');

        $query = Booking::with(['service', 'barber'])
            ->orderBy('booking_date', 'asc')
            ->orderBy('booking_time', 'asc');

        if ($status) {
            $query->where('status', $status);
        }

        if ($serviceId) {
            $query->where('service_id', $serviceId);
        }

        if ($barberId) {
            $query->where('barber_id', $barberId);
        }

        if ($date) {
            $query->whereDate('booking_date', $date);
        }

        if ($from && $to) {
            $query->whereBetween('booking_date', [$from, $to]);
        }

        $bookings = $query->paginate(20)->withQueryString();

        $services = \App\Models\Service::orderBy('name')->get(['id', 'name']);
        $barbers = \App\Models\Barber::orderBy('name')->get(['id', 'name']);

        return view('bookings.index', compact('bookings', 'services', 'barbers'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'status' => ['required', 'in:confirmed,cancelled'],
        ]);

        $booking->update([
            'status' => $data['status'],
        ]);

        if (!empty($booking->email)) {
            try {
                Mail::to($booking->email)->send(new BookingStatusChangedMail($booking));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $code = str_pad($booking->id, 5, '0', STR_PAD_LEFT);

        if ($request->input('redirect_to') === 'show') {
            $message = $data['status'] === 'confirmed'
                ? 'La reserva fue confirmada.'
                : 'La reserva fue cancelada.';
        } else {
            $message = $data['status'] === 'confirmed'
                ? "La reserva #{$code} fue confirmada."
                : "La reserva #{$code} fue cancelada.";
        }

        return back()->with('success', $message);
    }

    public function show(Booking $booking)
    {
        $booking->load('service');

        return view('bookings.show', compact('booking'));
    }

    public function print(Booking $booking)
    {
        $booking->load('service');

        return view('bookings.print', compact('booking'));
    }
}
