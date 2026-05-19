<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-[#0b0f14]">
                    Barberos
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Gestiona el equipo de barberos disponibles.
                </p>
            </div>

            <a href="{{ route('barbers.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-[#0b0f14] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-black">
                Nuevo barbero
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="rounded-3xl border border-black/5 bg-white shadow-sm overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">

                        <thead class="bg-gray-50 text-left">
                            <tr class="border-b border-gray-100">
                                <th class="px-6 py-4 font-semibold text-gray-500">
                                    Barbero
                                </th>

                                <th class="px-6 py-4 font-semibold text-gray-500">
                                    Rating
                                </th>

                                <th class="px-6 py-4 font-semibold text-gray-500">
                                    Estado
                                </th>

                                <th class="px-6 py-4"></th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse ($barbers as $barber)
                                <tr class="hover:bg-gray-50/70 transition">

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">

                                            <img src="{{ asset('storage/' . $barber->photo) }}"
                                                alt="{{ $barber->name }}"
                                                class="h-14 w-14 rounded-2xl object-cover border border-gray-200">

                                            <div>
                                                <div class="font-semibold text-[#0b0f14]">
                                                    {{ $barber->name }}
                                                </div>

                                                @if ($barber->short_description)
                                                    <div class="mt-1 text-sm text-gray-500">
                                                        {{ $barber->short_description }}
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div
                                            class="inline-flex items-center gap-1 rounded-full bg-[#fff8e1] px-3 py-1 text-sm font-semibold text-[#b28900]">
                                            ★ {{ number_format($barber->rating, 1) }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($barber->is_active)
                                            <span
                                                class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                Activo
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-600">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('barbers.edit', $barber) }}"
                                            class="text-sm font-semibold text-[#0b0f14] hover:text-black">
                                            Editar
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                                        No hay barberos registrados.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
