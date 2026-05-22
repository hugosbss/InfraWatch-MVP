<x-app-layout>
    <x-slot name="header">
        <x-infrawatch.page-header
            eyebrow="Incidentes"
            title="Historico de indisponibilidade"
            description="Quedas detectadas, duracao, erros e status de resolucao."
        />
    </x-slot>

    <livewire:incidents.index />
</x-app-layout>
