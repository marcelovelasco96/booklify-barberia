<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\BlockedSlot;
use App\Mail\BookingConfirmedMail;
use Illuminate\Support\Facades\Mail;

class PublicBookingController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('public.reservas', compact('services'));
    }

    public function show(Service $service)
    {
        abort_unless($service->is_active, 404);

        return view('public.reservas-show', compact('service'));
    }

    public function datos(Service $service)
    {
        abort_unless($service->is_active, 404);

        session()->forget('booking_data');

        return response()
            ->view('public.reservas-datos', compact('service'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function horarios(Service $service)
    {
        abort_unless($service->is_active, 404);

        $bookingData = session('booking_data');

        if (!$bookingData) {
            return redirect()
                ->route('public.reservas.datos', $service)
                ->with('error', 'Completa tus datos antes de elegir un horario.');
        }

        return response()
            ->view('public.reservas-horarios', compact('service'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }

    public function confirmar(Request $request, Service $service)
    {

        if ($request->filled('website')) {
            return redirect()->back()->withErrors([
                'throttle' => 'Demasiados intentos. Espera unos segundos antes de volver a intentar.',
            ]);
        }

        abort_unless($service->is_active, 404);

        if (!session()->has('booking_data')) {
            return redirect()
                ->route('public.reservas.datos', $service)
                ->with('error', 'Tu sesión expiró o abriste esta página en otra pestaña. Vuelve a ingresar tus datos para continuar.');
        }

        $data = $request->validate([
            'full_name'    => ['required', 'string', 'max:120'],
            'phone'        => ['required', 'string', 'max:20'],
            'email'        => ['nullable', 'email', 'max:120'],
            'booking_date' => ['required', 'date', 'before_or_equal:' . now()->addDays(60)->toDateString()],
            'booking_time' => ['required', 'date_format:H:i'],
        ]);

        $tz = config('app.timezone'); // debe ser America/Lima
        $bookingDateTime = \Illuminate\Support\Carbon::createFromFormat(
            'Y-m-d H:i',
            $data['booking_date'] . ' ' . $data['booking_time'],
            $tz
        );

        if ($bookingDateTime->lessThan(\Illuminate\Support\Carbon::now($tz))) {
            return back()
                ->withErrors(['booking_time' => 'No puedes reservar en una fecha u hora pasada. Elige otro horario.'])
                ->withInput();
        }

        $exists = Booking::where('service_id', $service->id)
            ->where('booking_date', $data['booking_date'])
            ->where('booking_time', $data['booking_time'])
            ->where('status', 'confirmed')
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->withErrors([
                'booking_time' => "Ese horario ({$data['booking_date']} {$data['booking_time']}) ya está reservado. Elige otro.",
            ]);
        }

        $blocked = BlockedSlot::where('service_id', $service->id)
            ->where('blocked_date', $data['booking_date'])
            ->where(function ($q) use ($data) {
                $q->whereNull('blocked_time')
                    ->orWhere('blocked_time', $data['booking_time']);
            })
            ->exists();

        if ($blocked) {
            return back()
                ->withErrors(['booking_time' => 'Ese horario no está disponible.'])
                ->withInput();
        }

        $booking = Booking::create([
            'service_id'    => $service->id,
            'full_name'     => $data['full_name'],
            'phone'         => $data['phone'],
            'email'         => $data['email'] ?? null,
            'booking_date'  => $data['booking_date'],
            'booking_time'  => $data['booking_time'],
            'status'        => 'confirmed',
        ]);

        if (!empty($booking->email)) {
            Mail::to($booking->email)->send(new BookingConfirmedMail($booking));
        }

        session()->forget('booking_data');

        return redirect()
            ->route('public.reservas.confirmado', [
                'service' => $service->id,
                'booking' => $booking->id,
            ])
            ->with('just_confirmed', true);
    }

    public function confirmado(Request $request, Service $service)
    {
        abort_unless($service->is_active, 404);

        if (!$request->filled('booking')) {
            return redirect()->route('public.reservas');
        }

        $booking = Booking::where('id', $request->query('booking'))
            ->where('service_id', $service->id)
            ->first();

        if (!$booking) {
            return redirect()->route('public.reservas');
        }

        if (!session()->pull('just_confirmed')) {
            return redirect()->route('public.reservas');
        }

        return response()
            ->view('public.reservas-confirmado', compact('booking'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }

    public function horariosPost(Request $request, Service $service)
    {
        abort_unless($service->is_active, 404);

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:50',
            'email'     => 'nullable|email|max:255',
        ]);

        session([
            'booking_data' => $validated,
        ]);

        return redirect()->route('public.reservas.horarios', $service);
    }
}
