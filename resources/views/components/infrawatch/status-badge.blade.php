@props(['status'])

@php
    $status = $status instanceof \BackedEnum ? $status->value : $status;

    [$label, $classes] = match ($status) {
        'active' => ['ativo', 'bg-emerald-50 text-emerald-700'],
        'online' => ['online', 'bg-emerald-50 text-emerald-700'],
        'offline' => ['offline', 'bg-rose-50 text-rose-700'],
        'degraded' => ['degradado', 'bg-amber-50 text-amber-700'],
        'paused' => ['pausado', 'bg-slate-100 text-slate-600'],
        'open' => ['aberto', 'bg-rose-50 text-rose-700'],
        'resolved' => ['resolvido', 'bg-emerald-50 text-emerald-700'],
        default => [$status, 'bg-slate-100 text-slate-600'],
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {$classes}"]) }}>
    {{ $label }}
</span>
