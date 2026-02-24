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

        <main class="max-w-3xl mx-auto px-4 py-10">
            <div class="bg-white border rounded-xl p-8 space-y-6 shadow-sm">

                <div class="space-y-1">
                    <div class="text-2xl font-bold tracking-tight text-gray-900">
                        {{ $service->name }}
                    </div>

                    <div class="text-sm text-gray-600 flex items-center gap-2">
                        <span>{{ $service->duration_minutes }} minutos</span>
                        @if ($service->price)
                            <span class="text-gray-400">•</span>
                            <span>S/ {{ number_format($service->price, 2) }}</span>
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t">
                    <x-public.btn-gold :href="route('public.reservas.datos', $service)">
                        Continuar
                    </x-public.btn-gold>
                </div>

            </div>
        </main>
    </div>

</body>

</html>
