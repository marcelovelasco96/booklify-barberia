<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Servicios
            </h2>

            <a href="{{ route('services.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                + Nuevo servicio
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="py-2">Nombre</th>
                                <th class="py-2">Duración</th>
                                <th class="py-2">Precio</th>
                                <th class="py-2">Estado</th>
                                <th class="py-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($services as $service)
                                <tr class="border-b">
                                    <td class="py-2">{{ $service->name }}</td>
                                    <td class="py-2">{{ $service->duration_minutes }} min</td>
                                    <td class="py-2">
                                        {{ $service->price !== null ? number_format($service->price, 2) : '—' }}
                                    </td>
                                    <td class="py-2">
                                        @if ($service->is_active)
                                            <span class="px-2 py-1 rounded bg-green-100 text-green-800">Activo</span>
                                        @else
                                            <span class="px-2 py-1 rounded bg-gray-100 text-gray-700">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-right space-x-2">
                                        <a href="{{ route('services.edit', $service) }}"
                                           class="text-blue-600 hover:underline">Editar</a>

                                        <form action="{{ route('services.destroy', $service) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('¿Eliminar este servicio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-600">
                                        Aún no hay servicios. Crea el primero.
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
