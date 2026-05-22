<x-app-layout>
    <x-slot name="header">
        <x-infrawatch.page-header
            :eyebrow="$isEditing ? 'Editar monitor' : 'Novo monitor'"
            :title="$isEditing ? 'Atualizar monitoramento' : 'Cadastrar monitoramento'"
            description="Defina nome, alvo, tipo de verificacao, frequencia e timeout."
        />
    </x-slot>

    <livewire:monitors.form :monitor="$monitorId" />
</x-app-layout>
