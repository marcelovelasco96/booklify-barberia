{{-- resources/views/public/reservas-show.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $service->name }} | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen">

        @include('public.partials.header', [
            'logoPath' => 'images/cusi-logo.png',
            'title' => $service->name,
            'subtitle' => 'Confirma los detalles del servicio.',
            'backUrl' => route('public.reservas'),
        ])

        <main class="max-w-5xl mx-auto px-4 py-8">
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

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                <div class="lg:col-span-3 rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
                    <div class="overflow-hidden rounded-2xl">
                        <img src="{{ asset('images/' . $image) }}" alt="{{ $service->name }}"
                            class="h-72 w-full object-cover">
                    </div>

                    <div class="mt-6">
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Servicio seleccionado
                        </p>

                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-[#0b0f14]">
                            {{ $service->name }}
                        </h2>

                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Atención personalizada, acabado profesional y una experiencia pensada para que salgas con un
                            estilo limpio, moderno y bien trabajado.
                        </p>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">

                    <div class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-[#0b0f14]">
                            Detalles
                        </h3>

                        <div class="mt-5 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                    Duración
                                </div>
                                <div class="mt-2 font-bold text-[#0b0f14]">
                                    {{ $service->duration_minutes }} min
                                </div>
                            </div>

                            <div class="rounded-2xl bg-gray-50 p-4">
                                <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                    Precio
                                </div>
                                <div class="mt-2 font-bold text-[#0b0f14]">
                                    @if ($service->price)
                                        S/ {{ number_format($service->price, 2) }}
                                    @else
                                        Consultar
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-[#0b0f14]">
                            Incluye
                        </h3>

                        <div class="mt-4 space-y-3 text-sm text-gray-700">
                            <div class="flex gap-3">
                                <span class="text-[#c9a227] font-bold">✓</span>
                                <span>Atención profesional según el servicio elegido.</span>
                            </div>

                            <div class="flex gap-3">
                                <span class="text-[#c9a227] font-bold">✓</span>
                                <span>Acabado cuidado con estilo limpio y moderno.</span>
                            </div>

                            <div class="flex gap-3">
                                <span class="text-[#c9a227] font-bold">✓</span>
                                <span>Reserva rápida sin pago adelantado.</span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-black/5 bg-[#0b0f14] p-6 text-white shadow-sm">
                        <h3 class="text-lg font-bold">
                            Siguiente paso
                        </h3>

                        <p class="mt-2 text-sm leading-relaxed text-white/60">
                            Elige el barbero que prefieres para continuar con tu reserva.
                        </p>

                        <div class="mt-5">
                            <x-public.btn-gold :href="route('public.reservas.barberos', $service)">
                                Elegir barbero
                            </x-public.btn-gold>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

</body>

</html>
