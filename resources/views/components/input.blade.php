@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500']) !!}>
