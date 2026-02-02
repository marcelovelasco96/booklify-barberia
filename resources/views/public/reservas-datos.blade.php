{{-- resources/views/public/reservas-datos.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datos | {{ $service->name }} | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen">
        <header class="border-b bg-white">
            <div class="max-w-5xl mx-auto px-4 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Tus datos</h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Servicio: <span class="font-medium text-gray-800">{{ $service->name }}</span>
                    </p>
                </div>
                <a href="{{ route('public.reservas.show', $service) }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    ← Volver
                </a>
            </div>
        </header>

        <main class="max-w-3xl mx-auto px-4 py-10">
            <div class="bg-white border rounded-lg p-8">
                <div class="mb-6">
                    <div class="text-lg font-semibold">Completa para continuar</div>
                    <div class="text-sm text-gray-600">Aún no se enviará ninguna reserva en este paso.</div>
                </div>

                <form method="POST" action="{{ route('public.reservas.horarios.post', $service) }}">

                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="full_name">Nombre completo</label>
                        <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej: Juan Pérez" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="phone">Celular</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej: 999 999 999" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700" for="email">Email (opcional)</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Ej: cliente@correo.com">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md bg-indigo-600 px-4 py-3 text-sm font-medium text-white hover:bg-indigo-700">
                            Elegir fecha y hora
                        </button>
                    </div>
                </form>

            </div>
        </main>
    </div>

</body>

</html>
