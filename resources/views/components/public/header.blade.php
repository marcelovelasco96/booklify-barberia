@props(['title', 'subtitle' => null, 'backUrl' => null, 'logoPath' => null])

<header class="bg-[#0b0f14] text-white">
    <div class="max-w-5xl mx-auto px-4 py-5">

        <div class="flex items-center justify-between">

            <div class="flex items-center gap-4">

                @if ($backUrl)
                    <a href="{{ $backUrl }}" class="text-sm text-gray-300 hover:text-white transition">
                        ← Volver
                    </a>
                @endif

                @if ($logoPath)
                    <img src="{{ asset($logoPath) }}" alt="Logo" class="h-10 w-auto object-contain">
                @endif

            </div>

        </div>

        <div class="mt-6">
            <h1 class="text-3xl font-bold tracking-tight">
                {{ $title }}
            </h1>

            @if ($subtitle)
                <p class="mt-2 text-gray-300">
                    {{ $subtitle }}
                </p>
            @endif
        </div>

    </div>
</header>
