<x-app-layout>
    <x-slot name="header">
        <x-infrawatch.page-header
            eyebrow="Centro de operacao"
            title="Dashboard InfraWatch"
            description="Uptime, incidentes, latencia e status dos seus monitoramentos."
        />
    </x-slot>

    <livewire:dashboard.overview />
</x-app-layout>
