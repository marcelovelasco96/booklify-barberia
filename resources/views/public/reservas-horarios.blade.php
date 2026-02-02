@php
    $bookingData = session('booking_data');
@endphp

{{-- resources/views/public/reservas-horarios.blade.php --}}
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Horario | {{ $service->name }} | Booklify</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen">
        <header class="border-b bg-white">
            <div class="max-w-5xl mx-auto px-4 py-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Fecha y hora</h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Servicio: <span class="font-medium text-gray-800">{{ $service->name }}</span>
                    </p>
                </div>
                <a href="{{ route('public.reservas.datos', $service) }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    ← Volver
                </a>
            </div>
        </header>

        <main class="max-w-3xl mx-auto px-4 py-10">
            <div class="bg-white border rounded-lg p-8">

                @php
                    $bookingData = session('booking_data');
                @endphp

                @if ($bookingData)
                    <div class="mb-4 rounded-md border border-gray-200 bg-gray-50 p-4">
                        <p class="text-sm text-gray-700">
                            <span class="font-medium">Reservando para:</span>
                            {{ $bookingData['full_name'] }} — {{ $bookingData['phone'] }}
                            @if (!empty($bookingData['email']))
                                — {{ $bookingData['email'] }}
                            @endif
                        </p>
                    </div>
                @endif

                <form method="POST" action="{{ route('public.reservas.confirmar', $service) }}" class="space-y-6">
                    @csrf

                    <input type="text" name="website" style="display:none" autocomplete="off" tabindex="-1">

                    @if ($errors->any())
                        <div class="rounded-md border border-red-200 bg-red-50 p-4">
                            <div class="font-medium text-red-800 mb-2">Revisa lo siguiente:</div>
                            <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Datos del cliente (vienen desde /datos por querystring) --}}
                    <input type="hidden" name="full_name" value="{{ $bookingData['full_name'] }}">
                    <input type="hidden" name="phone" value="{{ $bookingData['phone'] }}">
                    <input type="hidden" name="email" value="{{ $bookingData['email'] ?? '' }}">

                    <div>
                        <div class="text-lg font-semibold">Elige una fecha</div>
                        <input type="date" name="booking_date" value="{{ old('booking_date') }}"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    <div>
                        <div class="text-lg font-semibold">Elige una hora</div>
                        <select name="booking_time"
                            class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                            <option value="">Selecciona una hora</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t">
                        <button type="submit" onclick="this.disabled=true; this.form.submit();"
                            class="w-full inline-flex justify-center rounded-md bg-indigo-600 px-4 py-3 text-sm font-medium text-white hover:bg-indigo-700">
                            Confirmar reserva
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>

</html>
