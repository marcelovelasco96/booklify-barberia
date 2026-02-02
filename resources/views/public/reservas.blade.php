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
        <header class="border-b bg-white">
            <div class="max-w-5xl mx-auto px-4 py-6">
                <h1 class="text-2xl font-bold">Reservas</h1>
                <p class="text-sm text-gray-600 mt-1">Elige un servicio para continuar.</p>
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
                                class="mt-5 block w-full rounded-md bg-indigo-600 px-4 py-3 text-center text-sm font-medium text-white hover:bg-indigo-700">
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
