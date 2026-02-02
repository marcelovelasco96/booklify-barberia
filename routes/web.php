<?php

use App\Http\Controllers\PublicBookingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BlockedSlotController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('services', ServiceController::class);
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/print', [BookingController::class, 'print'])->name('bookings.print');
    Route::get('/blocked-slots', [BlockedSlotController::class, 'index'])->name('blocked-slots.index');
    Route::post('/blocked-slots', [BlockedSlotController::class, 'store'])->name('blocked-slots.store');
    Route::delete('/blocked-slots/{blockedSlot}', [BlockedSlotController::class, 'destroy'])->name('blocked-slots.destroy');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::get('/reservas', [PublicBookingController::class, 'index'])
    ->name('public.reservas');

Route::get('/reservas/{service}', [PublicBookingController::class, 'show'])
    ->name('public.reservas.show');

Route::get('/reservas/{service}/datos', [PublicBookingController::class, 'datos'])
    ->name('public.reservas.datos');

Route::get('/reservas/{service}/horarios', [PublicBookingController::class, 'horarios'])
    ->name('public.reservas.horarios');

Route::post(
    '/reservas/{service}/horarios',
    [PublicBookingController::class, 'horariosPost']
)->name('public.reservas.horarios.post');

Route::post('/reservas/{service}/confirmar', [PublicBookingController::class, 'confirmar'])
    ->middleware('throttle:10,1')
    ->name('public.reservas.confirmar');

Route::get('/reservas/{service}/confirmado', [PublicBookingController::class, 'confirmado'])
    ->name('public.reservas.confirmado');

Route::get('/robots.txt', function () {
    $content = "User-agent: *\n";

    if (app()->environment('production')) {
        $content .= "Disallow: /\n";
    } else {
        $content .= "Disallow:\n";
    }

    return response($content, 200)->header('Content-Type', 'text/plain');
});

require __DIR__ . '/auth.php';
