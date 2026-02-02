{{-- resources/views/services/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar servicio
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <div class="text-lg font-semibold text-gray-900">Editar: {{ $service->name }}</div>
                            <div class="text-sm text-gray-600">Actualiza los datos del servicio.</div>
                        </div>
                        <a href="{{ route('services.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Volver
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="mb-6 rounded-md border border-red-200 bg-red-50 p-4">
                            <div class="font-medium text-red-800 mb-2">Revisa los siguientes campos:</div>
                            <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('services.update', $service) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input id="name" name="name" type="text"
                                   value="{{ old('name', $service->name) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required autofocus>
                        </div>

                        <div>
                            <label for="duration_minutes" class="block text-sm font-medium text-gray-700">Duración (minutos)</label>
                            <input id="duration_minutes" name="duration_minutes" type="number" min="1"
                                   value="{{ old('duration_minutes', $service->duration_minutes) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   required>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700">Precio (opcional)</label>
                            <input id="price" name="price" type="number" step="0.01" min="0"
                                   value="{{ old('price', $service->price) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Ej: 25.00">
                            <p class="mt-1 text-xs text-gray-500">Déjalo vacío si no aplica.</p>
                        </div>

                        <div class="flex items-center gap-3">
                            <input id="is_active" name="is_active" type="checkbox" value="1"
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                   {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="text-sm text-gray-700">Activo</label>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('services.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-indigo-700">
                                Guardar cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
