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

        @include('public.partials.header', [
            'logoPath' => 'images/cusi-logo.png',
            'title' => 'Tus datos',
            'subtitle' =>
                'Servicio: <span class="font-medium text-white">' .
                e($service->name) .
                '</span> · Barbero: <span class="font-medium text-white">' .
                e($barber->name) .
                '</span>',
            'backUrl' => route('public.reservas.barberos', $service),
        ])

        <main class="max-w-3xl mx-auto px-4 py-10">

            @if (session('error'))
                <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white border rounded-lg p-8">
                <div class="mb-6">
                    <div class="text-lg font-semibold">Completa para continuar</div>
                    <div class="text-sm text-gray-600">Aún no se enviará ninguna reserva en este paso.</div>
                </div>

                <form method="POST" action="{{ route('public.reservas.horarios.post', $service) }}">

                    @csrf

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="full_name">Nombre
                                completo</label>
                            <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Ej: Juan Pérez" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="phone">Celular</label>
                            <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Ej: 999 999 999" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email">Email
                                (opcional)</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Ej: cliente@correo.com">
                        </div>
                    </div>

                    <div class="pt-2">
                        <x-public.btn-gold type="submit">
                            Elegir fecha y hora
                        </x-public.btn-gold>
                    </div>
                </form>

            </div>
        </main>
    </div>

</body>

</html>
