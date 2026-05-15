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

        @include('public.partials.header', [
            'logoPath' => 'images/cusi-logo.png',
            'title' => 'Fecha y hora',
            'subtitle' => 'Servicio: <span class="font-medium text-white">' . e($service->name) . '</span>',
            'backUrl' => route('public.reservas.datos', $service),
        ])

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

                <form method="POST" action="{{ route('public.reservas.confirmar', $service) }}" class="space-y-6"
                    data-ocupados-url="{{ route('public.reservas.ocupados', $service) }}">
                    @csrf

                    <input type="text" name="website" style="display:none" autocomplete="off" tabindex="-1">

                    @if ($errors->any())
                        <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                            <div class="font-semibold mb-1">Revisa lo siguiente:</div>
                            <ul class="list-disc list-inside space-y-1">
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
                        <div class="text-lg font-semibold">Fecha</div>
                        <input id="booking_date" type="date" name="booking_date" value="{{ old('booking_date') }}"
                            class="flatpickr-input mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            placeholder="Selecciona una fecha" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Selecciona tu horario
                        </label>

                        <input type="hidden" name="booking_time" id="booking_time" value="{{ old('booking_time') }}"
                            required>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3" id="time-slots">
                            @foreach (['08:00', '09:00', '10:00', '11:00', '12:00', '15:00', '16:00', '17:00'] as $time)
                                <button type="button" data-time="{{ $time }}"
                                    class="time-slot rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-800 shadow-sm hover:border-[#c9a227] hover:bg-yellow-50 transition">
                                    {{ $time }}
                                </button>
                            @endforeach
                        </div>

                        @error('booking_time')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($errors->has('throttle'))
                        <div class="mb-4 rounded border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                            {{ $errors->first('throttle') }}
                        </div>
                    @endif

                    <div class="pt-4 border-t">
                        <button id="confirmButton" type="submit" disabled
                            style="display:block; width:100%; margin-top:16px; background:#d1d5db; color:#6b7280; padding:12px 14px; border-radius:10px; font-weight:600; text-align:center; box-shadow:0 8px 20px rgba(0,0,0,.08); border:1px solid rgba(0,0,0,.08); transition:0.2s; cursor:not-allowed;">
                            Confirmar reserva
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#booking_date", {
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d/m/Y",
                minDate: "today",
                disableMobile: true,
                locale: {
                    firstDayOfWeek: 1
                },
                onChange: function() {
                    dateInput.dispatchEvent(new Event('change'));
                }
            });
            const form = document.querySelector('form[data-ocupados-url]');
            const dateInput = document.getElementById('booking_date');
            const hiddenInput = document.getElementById('booking_time');
            const buttons = document.querySelectorAll('.time-slot');
            const confirmButton = document.getElementById('confirmButton');

            function updateConfirmButton() {
                const canSubmit = Boolean(dateInput.value && hiddenInput.value);

                confirmButton.disabled = !canSubmit;

                if (canSubmit) {
                    confirmButton.style.background = '#c9a227';
                    confirmButton.style.color = '#0b0f14';
                    confirmButton.style.cursor = 'pointer';
                    confirmButton.style.boxShadow = '0 8px 20px rgba(0,0,0,.15)';
                } else {
                    confirmButton.style.background = '#d1d5db';
                    confirmButton.style.color = '#6b7280';
                    confirmButton.style.cursor = 'not-allowed';
                    confirmButton.style.boxShadow = '0 8px 20px rgba(0,0,0,.08)';
                }
            }

            function resetButtons() {
                buttons.forEach(btn => {
                    btn.disabled = false;
                    btn.classList.remove(
                        'bg-[#c9a227]', 'border-[#c9a227]', 'text-[#0b0f14]',
                        'bg-gray-100', 'border-gray-200', 'text-gray-400', 'cursor-not-allowed'
                    );
                    btn.classList.add('bg-white', 'border-gray-200', 'text-gray-800');
                    btn.textContent = btn.dataset.time;
                });

                hiddenInput.value = '';
                updateConfirmButton();
            }

            function selectTime(button) {
                if (button.disabled) return;

                buttons.forEach(btn => {
                    if (!btn.disabled) {
                        btn.classList.remove('bg-[#c9a227]', 'border-[#c9a227]', 'text-[#0b0f14]');
                        btn.classList.add('bg-white', 'border-gray-200', 'text-gray-800');
                    }
                });

                button.classList.remove('bg-white', 'border-gray-200', 'text-gray-800');
                button.classList.add('bg-[#c9a227]', 'border-[#c9a227]', 'text-[#0b0f14]');

                hiddenInput.value = button.dataset.time;
                updateConfirmButton();
            }

            async function loadOcupados() {
                resetButtons();

                if (!dateInput.value) return;

                const url = `${form.dataset.ocupadosUrl}?date=${encodeURIComponent(dateInput.value)}`;

                const response = await fetch(url);
                const data = await response.json();

                const ocupados = data.ocupados || [];

                buttons.forEach(button => {
                    if (ocupados.includes(button.dataset.time)) {
                        button.disabled = true;
                        button.classList.remove('bg-white', 'text-gray-800');
                        button.classList.add('bg-gray-100', 'text-gray-400', 'cursor-not-allowed');
                        button.textContent = button.dataset.time;
                    }
                });

                updateConfirmButton();
            }

            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    selectTime(button);
                });
            });

            dateInput.addEventListener('change', loadOcupados);

            if (dateInput.value) {
                loadOcupados();
            } else {
                updateConfirmButton();
            }
        });
    </script>

</body>

</html>
