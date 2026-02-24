<header class="border-b text-white" style="background:#080b10;">
    <div class="max-w-5xl mx-auto px-4 py-5 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4 min-w-0">
            @if (!empty($logoPath))
                <img src="{{ asset($logoPath) }}" alt="Logo" class="h-14 md:h-16 w-auto object-contain" />
            @endif

            <div class="min-w-0">
                <h1 class="text-2xl font-bold leading-tight truncate">{{ $title ?? config('app.name') }}</h1>

                @if (!empty($subtitle))
                    <p class="text-sm text-gray-300 mt-1 truncate">
                        {!! $subtitle !!}
                    </p>
                @endif
            </div>
        </div>

        @if (!empty($backUrl))
            <a href="{{ $backUrl }}"
                class="inline-flex items-center px-4 py-2 border border-white/20 rounded-md text-sm font-medium text-white hover:bg-white/10">
                ← Volver
            </a>
        @endif
    </div>
</header>
