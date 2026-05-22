<x-app-layout>
    <x-slot name="header">
        <x-infrawatch.page-header
            eyebrow="Monitoramentos"
            title="Sites, APIs e servidores"
            description="Cadastre alvos HTTP/HTTPS e acompanhe disponibilidade em tempo real."
        >
            <x-slot name="actions">
                <a href="{{ route('monitors.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    Novo monitor
                </a>
            </x-slot>
        </x-infrawatch.page-header>
    </x-slot>

    <livewire:monitors.index />
</x-app-layout>
