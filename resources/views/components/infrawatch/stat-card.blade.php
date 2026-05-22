@props([
    'label',
    'value',
    'hint' => null,
    'badge' => null,
    'badgeTone' => 'neutral',
])

@php
    $badgeClasses = match ($badgeTone) {
        'success' => 'bg-emerald-50 text-emerald-700',
        'warning' => 'bg-amber-50 text-amber-700',
        'danger' => 'bg-rose-50 text-rose-700',
        default => 'bg-slate-100 text-slate-600',
    };
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg border border-slate-200 bg-white p-5 shadow-sm']) }}>
    <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
    <div class="mt-3 flex items-end justify-between gap-3">
        <span class="text-3xl font-bold text-slate-950">{{ $value }}</span>
        @if ($badge)
            <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $badgeClasses }}">{{ $badge }}</span>
        @elseif ($hint)
            <span class="text-xs font-semibold text-slate-400">{{ $hint }}</span>
        @endif
    </div>
</div>
