@props([
    'eyebrow' => null,
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between']) }}>
    <div>
        @if ($eyebrow)
            <p class="text-sm font-semibold text-teal-700">{{ $eyebrow }}</p>
        @endif
        <h1 @class(['font-bold text-slate-950', 'mt-1 text-2xl' => $eyebrow, 'text-2xl' => ! $eyebrow])>{{ $title }}</h1>
        @if ($description)
            <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
        @endif
    </div>

    @if (isset($actions))
        <div class="flex flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
