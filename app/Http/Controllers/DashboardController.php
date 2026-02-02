<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        // Semana (Lun-Dom)
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $countToday = Booking::whereDate('booking_date', $today)->count();
        $countTomorrow = Booking::whereDate('booking_date', $tomorrow)->count();
        $countThisWeek = Booking::whereBetween('booking_date', [
            $startOfWeek->toDateString(),
            $endOfWeek->toDateString(),
        ])->count();

        $countConfirmed = Booking::where('status', 'confirmed')->count();
        $countCancelled = Booking::where('status', 'cancelled')->count();

        $nextBookings = Booking::with('service')
            ->whereDate('booking_date', '>=', $today)
            ->orderBy('booking_date', 'asc')
            ->orderBy('booking_time', 'asc')
            ->limit(8)
            ->get();

        return view('dashboard', compact(
            'countToday',
            'countTomorrow',
            'countThisWeek',
            'countConfirmed',
            'countCancelled',
            'nextBookings'
        ));
    }
}
