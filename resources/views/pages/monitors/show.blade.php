<x-app-layout>
    <x-slot name="header">
        <x-infrawatch.page-header
            eyebrow="Detalhes do monitor"
            :title="$monitorName"
            description="Historico de checks, incidentes e metricas do servico."
        >
            <x-slot name="actions">
                <a href="{{ route('monitors.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Voltar
                </a>
            </x-slot>
        </x-infrawatch.page-header>
    </x-slot>

    <livewire:monitors.show :monitor="$monitorId" />
</x-app-layout>
