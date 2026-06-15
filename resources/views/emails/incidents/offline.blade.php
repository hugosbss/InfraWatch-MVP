@php
    $checkedAt = $incident->started_at->timezone(config('app.timezone'))->format('d/m/Y H:i');
    $monitorUrl = route('monitors.show', $monitor);
@endphp

<x-mail::message>
# InfraWatch

## Monitor offline

O monitor **{{ $monitor->name }}** confirmou uma indisponibilidade apos as tentativas de seguranca.

<x-mail::panel>
**Status: Offline**

| Campo | Detalhe |
| :--- | :--- |
| Host | {{ $monitor->target }} |
| Horario | {{ $checkedAt }} |
| Erro | {{ $incident->error_message ?? 'Falha detectada pelo monitor.' }} |
</x-mail::panel>

<x-mail::button :url="$monitorUrl" color="primary">
Ver monitor
</x-mail::button>

O InfraWatch nao reenviara este alerta para o mesmo incidente enquanto ele permanecer aberto.
</x-mail::message>
