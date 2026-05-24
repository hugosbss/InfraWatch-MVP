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
                    <option value="active">Ativo</option>
                    <option value="paused">Pausado</option>
                </select>
                <select wire:model.live="typeFilter" class="rounded-lg border-slate-300 text-sm shadow-sm focus:border-teal-500 focus:ring-teal-500">
                    <option value="all">Todos os tipos</option>
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
            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500">
                            <tr>
                                <th class="px-5 py-3 text-start">Monitor</th>
                                <th class="px-5 py-3 text-start">Status</th>
                                <th class="px-5 py-3 text-start">Tipo</th>
                                <th class="px-5 py-3 text-start">Frequencia</th>
                                <th class="px-5 py-3 text-start">Ultima resposta</th>
                                <th class="px-5 py-3 text-end">Acoes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($monitors as $monitor)
                                @php($latestLog = $monitor->latestLog)
                                <tr>
                                    <td class="px-5 py-4">
                                        <div class="max-w-xs">
                                            <a href="{{ route('monitors.show', $monitor) }}" class="font-bold text-slate-950 hover:text-teal-700">{{ $monitor->name }}</a>
                                            <p class="mt-1 truncate text-slate-500">{{ $monitor->target }}</p>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <x-infrawatch.status-badge :status="$monitor->status" />
                                    </td>
                                    <td class="px-5 py-4 font-semibold uppercase text-slate-700">{{ $monitor->type }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $monitor->frequency }}</td>
                                    <td class="px-5 py-4 text-slate-600">{{ $latestLog?->response_time_ms ? $latestLog->response_time_ms.' ms' : '—' }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('monitors.edit', $monitor) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                                Editar
                                            </a>
                                            <button type="button" wire:click="togglePause({{ $monitor->id }})" class="inline-flex items-center justify-center rounded-lg bg-amber-50 px-3 py-2 text-sm font-semibold text-amber-800 transition hover:bg-amber-100">
                                                {{ $monitor->status === 'paused' ? 'Ativar' : 'Pausar' }}
                                            </button>
                                            <button type="button" wire:click="delete({{ $monitor->id }})" wire:confirm="Excluir este monitor?" class="inline-flex items-center justify-center rounded-lg bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-700 transition hover:bg-rose-100">
                                                Excluir
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
