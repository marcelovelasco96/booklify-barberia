{{-- resources/views/public/reservas.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reservas | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[radial-gradient(circle_at_top,#f8f6ef_0%,#f3f4f6_45%,#eef0f3_100%)] text-gray-900">

    <div class="min-h-screen">
        <header class="border-b text-white" style="background:#080b10;">
            <div class="flex items-center gap-3">

                <img src="{{ asset('images/cusi-logo.png') }}" alt="CUSI BARBERSHOP"
                    style="height:72px; max-width:180px; object-fit:contain;" class="rounded bg-black/20 p-1">
                <div>
                    <h1 class="text-2xl font-bold text-white">{{ config('app.name') }}</h1>
                    <p class="text-sm text-gray-300 mt-1">Atención premium en cada detalle.</p>
                </div>

            </div>
        </header>

        <main class="max-w-6xl mx-auto px-4 py-6">

            <section class="mb-5 rounded-3xl border border-gray-200 bg-white px-6 py-5 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-gray-500">
                    Servicios disponibles
                </p>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-gray-900">
                    Elige el servicio que deseas reservar
                </h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-600">
                    Selecciona una opción, confirma los detalles y agenda tu cita en pocos segundos.
                </p>
            </section>

            @if ($services->isEmpty())

                <div
                    class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm hover:-translate-y-1 hover:shadow-xl transition-all duration-300">

                    <div class="font-semibold">Aún no hay servicios disponibles.</div>
                    <div class="text-sm text-gray-600 mt-1">Vuelve más tarde.</div>

                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">

                    @foreach ($services as $service)
                        <div
                            class="group bg-white border border-gray-200 rounded-3xl p-5 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 overflow-hidden">

                            <div class="mb-5 overflow-hidden rounded-2xl">
                                @php
                                    $image = match (strtolower($service->name)) {
                                        'afeitado completo' => 'afeitado.jpg',
                                        'corte + barba' => 'corte.jpg',
                                        'corte clásico' => 'clasico.jpg',
                                        'corte premium' => 'premium.jpg',
                                        'solo barba' => 'barba.jpg',
                                        default => 'corte.jpg',
                                    };
                                @endphp

                                <img src="{{ asset('images/' . $image) }}"
                                    class="h-36 w-full rounded-xl object-cover border border-gray-100"
                                    alt="{{ $service->name }}">
                            </div>

                            <div class="text-lg font-semibold tracking-tight text-gray-900">{{ $service->name }}</div>

                            <div class="mt-3 text-sm text-gray-700 space-y-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-400">⏱️</span>
                                    <span>{{ $service->duration_minutes }} minutos</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-gray-400">💳</span>

                                    @if (is_null($service->price))
                                        <span class="text-gray-600">Precio a consultar</span>
                                    @else
                                        <span class="font-medium text-gray-900">
                                            S/ {{ number_format($service->price, 2) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('public.reservas.show', $service) }}"
                                class="mt-5 inline-flex w-full items-center justify-center rounded-xl px-4 py-3
                                        font-semibold tracking-wide text-[#0b0f14]
                                        bg-[#c9a227] border border-black/10 shadow-[0_10px_24px_rgba(0,0,0,0.12)]
                                        hover:bg-[#d4af37] active:scale-[0.99]
                                        transition">
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
