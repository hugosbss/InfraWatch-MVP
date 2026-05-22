@props([
    'title',
    'description',
])

<div {{ $attributes->merge(['class' => 'rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center']) }}>
    <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-teal-50 text-teal-700">
        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </div>
    <h3 class="mt-4 text-lg font-bold text-slate-950">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">{{ $description }}</p>
    @if (isset($action))
        <div class="mt-6">
            {{ $action }}
        </div>
    @endif
</div>
