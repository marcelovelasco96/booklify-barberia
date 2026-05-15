<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Elegir barbero | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-b from-[#f8f8f7] to-[#f1f1ef] text-gray-900">

    <div class="min-h-screen">

        <x-public.header title="Elige tu barbero" subtitle="Selecciona al profesional que realizará tu servicio."
            logoPath="images/cusi-logo.png" :backUrl="route('public.reservas.show', $service)" />

        <main class="max-w-5xl mx-auto px-4 py-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($barbers as $barber)
                    <a href="{{ route('public.reservas.datos', $service) }}"
                        class="group rounded-3xl border border-black/5 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                        {{-- Foto --}}
                        <div class="aspect-square overflow-hidden rounded-2xl bg-gray-100">
                            <img src="{{ asset('storage/' . $barber->photo) }}" alt="{{ $barber->name }}"
                                class="h-full w-full object-cover group-hover:scale-105 transition duration-300">
                        </div>

                        {{-- Info --}}
                        <div class="mt-4">

                            <h3 class="text-lg font-bold tracking-tight text-[#0b0f14]">
                                {{ $barber->name }}
                            </h3>

                            <div class="mt-2 flex items-center gap-2">
                                <span class="text-[#d4af37]">★</span>

                                <span class="text-sm font-semibold text-gray-700">
                                    {{ number_format($barber->rating, 1) }}
                                </span>
                            </div>

                            @if ($barber->short_description)
                                <p class="mt-3 text-sm leading-relaxed text-gray-500">
                                    {{ $barber->short_description }}
                                </p>
                            @endif

                        </div>

                    </a>
                @endforeach

            </div>

        </main>

    </div>

</body>

</html>
