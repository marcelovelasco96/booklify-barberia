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
        <header class="border-b bg-white">
            <div class="max-w-5xl mx-auto px-4 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">{{ $service->name }}</h1>
                    <p class="text-sm text-gray-600 mt-1">Confirma los detalles del servicio.</p>
                </div>
                <a href="{{ route('public.reservas') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    ← Volver
                </a>
            </div>
        </header>

        <main class="max-w-3xl mx-auto px-4 py-10">
            <div class="bg-white border rounded-lg p-8 space-y-6">

                <div class="space-y-2">
                    <div class="text-lg font-semibold">Servicio</div>
                    <div class="text-gray-700">{{ $service->name }}</div>
                </div>

                <div class="space-y-2">
                    <div class="text-lg font-semibold">Duración</div>
                    <div class="text-gray-700">{{ $service->duration_minutes }} minutos</div>
                </div>

                <div class="space-y-2">
                    <div class="text-lg font-semibold">Precio</div>
                    <div class="text-gray-700">
                        @if (is_null($service->price))
                            Precio a consultar
                        @else
                            S/ {{ number_format($service->price, 2) }}
                        @endif
                    </div>
                </div>

                <div class="pt-4 border-t">
                    <a href="{{ route('public.reservas.datos', $service) }}"
                        class="w-full inline-flex justify-center rounded-md bg-indigo-600 px-4 py-3 text-sm font-medium text-white hover:bg-indigo-700">
                        Confirmar y continuar
                    </a>
                </div>

            </div>
        </main>
    </div>

</body>

</html>
