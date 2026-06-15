@php
    $team = $invitation->team;
@endphp

<x-mail::message>
# InfraWatch

## Convite para equipe

Voce recebeu um convite para participar da equipe **{{ $team->name }}** no InfraWatch.

<x-mail::panel>
**Acesso colaborativo**

| Campo | Detalhe |
| :--- | :--- |
| Equipe | {{ $team->name }} |
| Enviado para | {{ $invitation->email }} |
| Produto | {{ config('app.name', 'InfraWatch') }} |
</x-mail::panel>

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
Se voce ainda nao tem uma conta, crie seu cadastro primeiro. Depois volte neste e-mail e aceite o convite da equipe.
@else
Para entrar na equipe, aceite o convite pelo botao abaixo.
@endif

<x-mail::button :url="$acceptUrl" color="primary">
Aceitar convite
</x-mail::button>

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
<x-mail::button :url="route('register')" color="primary">
Criar conta
</x-mail::button>
@endif

Se voce nao esperava este convite, basta ignorar este e-mail.
</x-mail::message>
