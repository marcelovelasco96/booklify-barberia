<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        RateLimiter::for('public-booking', function (Request $request) {
            // clave: IP + user-agent (reduce bots básicos y “shared IP”)
            $key = sha1(($request->ip() ?? 'na') . '|' . substr((string) $request->userAgent(), 0, 120));

            return [
                // 1) Confirmar (POST): más estricto
                Limit::perMinute(6)->by($key),

                // 2) “Burst” controlado (evita ráfagas)
                Limit::perHour(40)->by($key),
            ];
        });
    }
}
