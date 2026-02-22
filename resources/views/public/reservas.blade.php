{{-- resources/views/public/reservas.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservas | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen">
        <header class="border-b text-white" style="background:#080b10;">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/cusi-logo.png') }}" alt="CUSI BARBERSHOP"
                    style="height:72px; max-width:180px; object-fit:contain;" class="rounded bg-black/20 p-1">
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ config('app.name') }}</h1>
                    <p class="text-sm text-gray-300 mt-1">Reserva tu cita en pocos segundos.</p>
                </div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-4 py-10">
            @if ($services->isEmpty())
                <div class="bg-white border rounded-lg p-6">
                    <div class="font-semibold">Aún no hay servicios disponibles.</div>
                    <div class="text-sm text-gray-600 mt-1">Vuelve más tarde.</div>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($services as $service)
                        <div class="bg-white border rounded-lg p-6 hover:shadow-sm transition">
                            <div class="text-lg font-semibold">{{ $service->name }}</div>

                            <div class="mt-2 text-sm text-gray-700 space-y-1">
                                <div>⏱️ {{ $service->duration_minutes }} minutos</div>

                                <div>
                                    💳
                                    @if (is_null($service->price))
                                        <span class="text-gray-600">Precio a consultar</span>
                                    @else
                                        S/ {{ number_format($service->price, 2) }}
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('public.reservas.show', $service) }}"
                                style="display:block; width:100%; margin-top:16px; background:#c9a227; color:#0b0f14; padding:12px 14px; border-radius:10px; font-weight:600; text-align:center; box-shadow:0 8px 20px rgba(0,0,0,.15); border:1px solid rgba(0,0,0,.12); transition:0.2s;"
                                onmouseover="this.style.background='#d4af37'"
                                onmouseout="this.style.background='#c9a227'">
                                Reservar
                            </a>

                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>

</body>

</html>
