<div class="py-8" wire:poll.30s>
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <x-infrawatch.stat-card label="Uptime medio" :value="$stats['uptime']" badge="estavel" badge-tone="success" />
            <x-infrawatch.stat-card label="Monitoramentos" :value="$stats['monitors']" :hint="$stats['online'].' online'" />
            <x-infrawatch.stat-card label="Incidentes abertos" :value="$stats['incidents']" :badge="$stats['incidents'] > 0 ? 'atencao' : 'limpo'" :badge-tone="$stats['incidents'] > 0 ? 'danger' : 'neutral'" />
            <x-infrawatch.stat-card label="Latencia media" :value="$stats['latency']" hint="checks reais" />
        </section>

        <section class="grid gap-6 lg:grid-cols-[1.35fr_.65fr]">
            <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-slate-200 p-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950">Status dos monitoramentos</h2>
                        <p class="mt-1 text-sm text-slate-500">Visao geral de sites, APIs e servidores.</p>
                    </div>
                    <a href="{{ route('monitors.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                        Novo monitor
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500">
                            <tr>
                                <th class="px-5 py-3 text-start">Servico</th>
                                <th class="px-5 py-3 text-start">Status</th>
                                <th class="px-5 py-3 text-start">Resposta</th>
                                <th class="px-5 py-3 text-start">Ultimo check</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($monitors as $monitor)
                                <tr class="hover:bg-slate-50/80">
                                    <td class="px-5 py-4">
                                        <a href="{{ route('monitors.show', $monitor) }}" class="font-semibold text-slate-900 hover:text-teal-700">{{ $monitor->name }}</a>
                                        <p class="mt-0.5 truncate text-xs text-slate-500">{{ $monitor->target }}</p>
                                    </td>
                                    <td class="px-5 py-4"><x-infrawatch.status-badge :status="$monitor->operationalStatus()" /></td>
                                    <td class="px-5 py-4 text-slate-600">{{ $monitor->latestLog?->response_time_ms ? $monitor->latestLog->response_time_ms.' ms' : '—' }}</td>
                                    <td class="px-5 py-4 text-slate-500">{{ $monitor->latestLog?->checked_at?->format('d/m H:i') ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-slate-500">Nenhum monitor cadastrado ainda.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 p-4 text-end">
                    <a href="{{ route('monitors.index') }}" class="text-sm font-semibold text-teal-700 hover:text-teal-800">Ver todos os monitoramentos</a>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-lg font-bold text-slate-950">Ultimos incidentes</h2>
                    <div class="mt-4 space-y-3">
                        @forelse ($incidents as $incident)
                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-950">{{ $incident->monitor->name }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $incident->started_at->format('d/m H:i') }} · {{ $incident->durationLabel() }}</p>
                                    </div>
                                    <x-infrawatch.status-badge :status="$incident->status" />
                                </div>
                                <p class="mt-2 text-sm text-slate-600">{{ $incident->error_message ?? 'Falha detectada pelo monitor.' }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500">Nenhum incidente registrado.</p>
                        @endforelse
                    </div>
                    <a href="{{ route('incidents.index') }}" class="mt-4 inline-flex text-sm font-semibold text-teal-700 hover:text-teal-800">Historico completo</a>
                </div>

                <div class="rounded-lg border border-slate-200 bg-slate-950 p-5 text-white shadow-sm">
                    <h2 class="text-lg font-bold">Checks recentes</h2>
                    <ul class="mt-4 space-y-3">
                        @forelse ($checks as $check)
                            <li class="flex items-center justify-between rounded-lg bg-white/10 px-3 py-2 text-sm">
                                <span>{{ $check->monitor->name }}</span>
                                <span class="font-semibold text-teal-300">{{ $check->is_up ? ($check->response_time_ms ? $check->response_time_ms.' ms' : 'online') : 'falha' }}</span>
                            </li>
                        @empty
                            <li class="rounded-lg bg-white/10 px-3 py-2 text-sm text-slate-300">Nenhum check registrado.</li>
                        @endforelse
                    </ul>
                </div>
            </aside>
        </section>
    </div>
</div>
