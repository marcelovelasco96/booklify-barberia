<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo servicio
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <form method="POST" action="{{ route('services.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">
                                Nombre del servicio
                            </label>
                            <input type="text" name="name"
                                   value="{{ old('name') }}"
                                   required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('name')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">
                                Duración (minutos)
                            </label>
                            <input type="number" name="duration_minutes"
                                   value="{{ old('duration_minutes', 30) }}"
                                   min="5" step="5" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('duration_minutes')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">
                                Precio (opcional)
                            </label>
                            <input type="number" name="price"
                                   value="{{ old('price') }}"
                                   step="0.01" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('price')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_active" value="1"
                                       checked
                                       class="rounded border-gray-300">
                                <span class="ml-2 text-sm text-gray-700">
                                    Servicio activo
                                </span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('services.index') }}"
                               class="text-gray-600 hover:underline">
                                ← Volver
                            </a>

                            <button type="submit"
                                    class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                Guardar servicio
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
