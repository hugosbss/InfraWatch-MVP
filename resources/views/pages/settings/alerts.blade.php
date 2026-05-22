<x-app-layout>
    <x-slot name="header">
        <x-infrawatch.page-header
            eyebrow="Configuracoes"
            title="Canais de alerta"
            description="Configure email e Telegram para receber avisos de offline e recuperacao."
        />
    </x-slot>

    <livewire:settings.alert-channels />
</x-app-layout>
