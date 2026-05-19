<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-[#0b0f14]">
                Nuevo barbero
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Registra un nuevo profesional para las reservas.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
            <div class="rounded-3xl border border-black/5 bg-white p-8 shadow-sm">

                <form method="POST" action="{{ route('barbers.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Nombre</label>
                        <input name="name" value="{{ old('name') }}" required
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#c9a227] focus:ring-[#c9a227]">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Foto</label>
                        <input name="photo" type="file" accept="image/*"
                            class="mt-2 block w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm shadow-sm file:mr-4 file:rounded-lg file:border-0 file:bg-[#0b0f14] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-black">
                        @error('photo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700">Descripción corta</label>
                        <textarea name="short_description" rows="3"
                            class="mt-2 block w-full rounded-xl border-gray-300 shadow-sm focus:border-[#c9a227] focus:ring-[#c9a227]">{{ old('short_description') }}</textarea>
                        @error('short_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-3">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="rounded border-gray-300 text-[#c9a227] focus:ring-[#c9a227]">
                        <span class="text-sm font-medium text-gray-700">Activo</span>
                    </label>

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <a href="{{ route('barbers.index') }}"
                            class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </a>

                        <button type="submit"
                            class="rounded-xl bg-[#0b0f14] px-5 py-3 text-sm font-semibold text-white hover:bg-black">
                            Guardar barbero
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
