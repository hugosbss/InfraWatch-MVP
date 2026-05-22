<div class="py-8">
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="flex flex-1 flex-col gap-3 sm:flex-row">
                <div class="flex-1">
                    <label for="search" class="sr-only">Buscar</label>
                    <input
                        id="search"
                        type="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Buscar por nome ou URL..."
                        class="w-full rounded-lg border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500"
                    />
                </div>
                <select wire:model.live="statusFilter" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="all">Todos os status</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                    <option value="degraded">Degradado</option>
                    <option value="paused">Pausado</option>
                </select>
                <select wire:model.live="typeFilter" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="all">Todos os tipos</option>
                    <option value="https">HTTPS</option>
                    <option value="http">HTTP</option>
                    <option value="ping">Ping</option>
                </select>
            </div>
        </div>

        @if (count($monitors) === 0)
            <x-infrawatch.empty-state
                title="Nenhum monitor encontrado"
                description="Ajuste os filtros ou cadastre um novo site, API ou servidor para comecar o monitoramento."
            >
                <x-slot name="action">
                    <a href="{{ route('monitors.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Cadastrar monitor
                    </a>
                </x-slot>
            </x-infrawatch.empty-state>
        @else
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($monitors as $monitor)
                    <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm transition hover:border-teal-200 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h2 class="truncate font-bold text-slate-950">{{ $monitor['name'] }}</h2>
                                <p class="mt-1 truncate text-sm text-slate-500">{{ $monitor['target'] }}</p>
                            </div>
                            <x-infrawatch.status-badge :status="$monitor['status']" />
                        </div>

                        <dl class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <dt class="text-slate-500">Tipo</dt>
                                <dd class="font-semibold uppercase text-slate-900">{{ $monitor['type'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Uptime</dt>
                                <dd class="font-semibold text-slate-900">{{ $monitor['uptime'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Resposta</dt>
                                <dd class="font-semibold text-slate-900">{{ $monitor['response_ms'] ? $monitor['response_ms'].' ms' : '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Frequencia</dt>
                                <dd class="font-semibold text-slate-900">{{ $monitor['frequency'] }}</dd>
                            </div>
                        </dl>

                        <div class="mt-5 flex gap-2">
                            <a href="{{ route('monitors.show', $monitor['id']) }}" class="inline-flex flex-1 items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Detalhes
                            </a>
                            <a href="{{ route('monitors.edit', $monitor['id']) }}" class="inline-flex flex-1 items-center justify-center rounded-lg bg-teal-50 px-3 py-2 text-sm font-semibold text-teal-800 transition hover:bg-teal-100">
                                Editar
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <p class="text-center text-xs text-slate-400">Dados de demonstracao — integracao com PostgreSQL na Etapa 2 do roadmap.</p>
    </div>
</div>
