{{-- resources/views/public/reservas-datos.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datos | {{ $service->name }} | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-b from-[#f8f8f7] to-[#f1f1ef] text-gray-900">

    <div class="min-h-screen">

        @include('public.partials.header', [
            'logoPath' => 'images/cusi-logo.png',
            'title' => 'Tus datos',
            'subtitle' => 'Déjanos tus datos para preparar tu reserva.',
            'backUrl' => route('public.reservas.barberos', $service),
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

            @if (session('error'))
                <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

                <section class="lg:col-span-3 rounded-3xl border border-black/5 bg-white p-8 shadow-sm">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                            Datos del cliente
                        </p>

                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-[#0b0f14]">
                            Completa tus datos
                        </h2>

                        <p class="mt-3 text-sm leading-relaxed text-gray-600">
                            Usaremos esta información para registrar tu reserva y contactarte si fuera necesario.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('public.reservas.horarios.post', $service) }}" class="mt-8">
                        @csrf

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700" for="full_name">
                                    Nombre completo
                                </label>

                                <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}"
                                    class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]"
                                    placeholder="Ej: Juan Pérez" required>

                                @error('full_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700" for="phone">
                                    Celular
                                </label>

                                <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                                    class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]"
                                    placeholder="Ej: 999 999 999" required>

                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700" for="email">
                                    Email <span class="font-normal text-gray-400">(opcional)</span>
                                </label>

                                <input id="email" name="email" type="email" value="{{ old('email') }}"
                                    class="mt-2 block w-full rounded-xl border-gray-200 bg-white px-4 py-3 text-sm shadow-sm transition focus:border-[#c9a227] focus:ring-[#c9a227]"
                                    placeholder="Ej: cliente@correo.com">

                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-8 border-t border-gray-100 pt-6">
                            <x-public.btn-gold type="submit">
                                Elegir fecha y hora
                            </x-public.btn-gold>
                        </div>
                    </form>
                </section>

                <aside class="lg:col-span-2 space-y-6">
                    <div class="rounded-3xl border border-black/5 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-bold text-[#0b0f14]">
                            Resumen
                        </h3>

                        <div class="mt-5 space-y-3">
                            <div class="flex items-center gap-4 rounded-2xl bg-gray-50 p-4">
                                <img src="{{ asset('images/' . $image) }}" alt="{{ $service->name }}"
                                    class="h-16 w-16 rounded-xl object-cover">

                                <div>
                                    <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        Servicio
                                    </div>

                                    <div class="mt-1 font-bold text-[#0b0f14]">
                                        {{ $service->name }}
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 rounded-2xl bg-gray-50 p-4">
                                <img src="{{ asset('storage/' . $barber->photo) }}" alt="{{ $barber->name }}"
                                    class="h-16 w-16 rounded-xl object-cover">

                                <div>
                                    <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        Barbero
                                    </div>

                                    <div class="mt-1 font-bold text-[#0b0f14]">
                                        {{ $barber->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-black/5 bg-[#0b0f14] p-6 text-white shadow-sm">
                        <h3 class="text-lg font-bold">
                            Aún no confirmas la reserva
                        </h3>

                        <p class="mt-2 text-sm leading-relaxed text-white/60">
                            En el siguiente paso elegirás la fecha y hora disponible antes de confirmar.
                        </p>
                    </div>
                </aside>

            </div>
        </main>
    </div>

</body>

</html>
