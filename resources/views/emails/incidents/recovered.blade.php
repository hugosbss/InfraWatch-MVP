@php
    $endedAt = $incident->ended_at?->timezone(config('app.timezone'))->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i');
    $monitorUrl = route('monitors.show', $monitor);
@endphp

<x-mail::message>
# InfraWatch

## Monitor recuperado

O monitor **{{ $monitor->name }}** voltou a responder normalmente.

<x-mail::panel>
**Status: Recuperado**

| Campo | Detalhe |
| :--- | :--- |
| Host | {{ $monitor->target }} |
| Recuperado em | {{ $endedAt }} |
| Duracao | {{ $incident->durationLabel() }} |
</x-mail::panel>

<x-mail::button :url="$monitorUrl" color="primary">
Ver monitor
</x-mail::button>

Este e o alerta de recuperacao do incidente. O envio tambem fica marcado para evitar repeticoes.
</x-mail::message>
