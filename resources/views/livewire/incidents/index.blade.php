<div class="py-8">
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        <section class="grid gap-4 sm:grid-cols-3">
            <x-infrawatch.stat-card label="Incidentes abertos" :value="(string) $openCount" :badge="$openCount > 0 ? 'acao necessaria' : 'estavel'" :badge-tone="$openCount > 0 ? 'danger' : 'success'" />
            <x-infrawatch.stat-card label="Resolvidos" :value="(string) $resolvedLastWeek" badge="ultimos 7 dias" />
            <x-infrawatch.stat-card label="Duracao media" :value="$averageDuration" hint="incidentes resolvidos" />
        </section>

        <div class="flex flex-wrap gap-2">
            <button type="button" wire:click="$set('statusFilter', 'all')" @class([
                'rounded-full px-4 py-2 text-sm font-semibold transition',
                'bg-slate-950 text-white' => $statusFilter === 'all',
                'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50' => $statusFilter !== 'all',
            ])>
                Todos
            </button>
            <button type="button" wire:click="$set('statusFilter', 'open')" @class([
                'rounded-full px-4 py-2 text-sm font-semibold transition',
                'bg-rose-600 text-white' => $statusFilter === 'open',
                'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50' => $statusFilter !== 'open',
            ])>
                Abertos
            </button>
            <button type="button" wire:click="$set('statusFilter', 'resolved')" @class([
                'rounded-full px-4 py-2 text-sm font-semibold transition',
                'bg-emerald-600 text-white' => $statusFilter === 'resolved',
                'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-slate-50' => $statusFilter !== 'resolved',
            ])>
                Resolvidos
            </button>
        </div>

        @if (count($incidents) === 0)
            <x-infrawatch.empty-state
                title="Nenhum incidente neste filtro"
                description="Incidentes sao abertos automaticamente apos falhas consecutivas nos checks do monitor."
            />
        @else
            <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500">
                        <tr>
                            <th class="px-5 py-3 text-start">ID</th>
                            <th class="px-5 py-3 text-start">Monitor</th>
                            <th class="px-5 py-3 text-start">Status</th>
                            <th class="px-5 py-3 text-start">Inicio</th>
                            <th class="px-5 py-3 text-start">Duracao</th>
                            <th class="px-5 py-3 text-start">Erro</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($incidents as $incident)
                            <tr class="align-top hover:bg-slate-50/80">
                                <td class="px-5 py-4 font-mono text-xs font-semibold text-slate-700">#{{ $incident->id }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-950">{{ $incident->monitor->name }}</p>
                                    <p class="mt-0.5 text-xs text-slate-500">{{ $incident->monitor->target }}</p>
                                </td>
                                <td class="px-5 py-4"><x-infrawatch.status-badge :status="$incident->status" /></td>
                                <td class="px-5 py-4 text-slate-600">{{ $incident->started_at->format('d/m/Y H:i') }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $incident->durationLabel() }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ $incident->error_message ?? 'Falha detectada pelo monitor.' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
