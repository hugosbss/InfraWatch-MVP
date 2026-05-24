<div class="py-8" x-data="{ tab: @entangle('activeTab') }">
    <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-3">
                        <h2 class="text-2xl font-bold text-slate-950">{{ $monitor->name }}</h2>
                        <x-infrawatch.status-badge :status="$monitor->status" />
                    </div>
                    <p class="mt-2 break-all text-sm text-slate-500">{{ $monitor->target }}</p>
                    <div class="mt-4 flex flex-wrap gap-2 text-xs font-semibold text-slate-600">
                        <span class="rounded-full bg-slate-100 px-3 py-1 uppercase">{{ $monitor->type }}</span>
                        <span class="rounded-full bg-slate-100 px-3 py-1">Frequencia: {{ $monitor->frequency }}</span>
                        <span class="rounded-full bg-slate-100 px-3 py-1">Timeout: {{ $monitor->timeout }}s</span>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('monitors.edit', $monitor) }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        Editar
                    </a>
                    <button type="button" wire:click="togglePause" class="inline-flex items-center justify-center rounded-lg bg-amber-50 px-4 py-2.5 text-sm font-semibold text-amber-800 transition hover:bg-amber-100">
                        {{ $monitor->status === 'paused' ? 'Ativar monitor' : 'Pausar monitor' }}
                    </button>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-infrawatch.stat-card label="Status" :value="$monitor->status === 'active' ? 'Ativo' : 'Pausado'" />
                <x-infrawatch.stat-card label="Ultima resposta" :value="$latestLog?->response_time_ms ? $latestLog->response_time_ms.' ms' : '—'" />
                <x-infrawatch.stat-card label="Ultimo check" :value="$latestLog?->checked_at?->format('d/m H:i') ?? '—'" />
                <x-infrawatch.stat-card label="Incidentes" :value="(string) count($incidents)" :badge="count($incidents) > 0 ? 'historico' : 'nenhum'" />
            </div>
        </section>

        <div class="border-b border-slate-200">
            <nav class="-mb-px flex gap-4" aria-label="Abas">
                <button type="button" @click="tab = 'overview'" :class="tab === 'overview' ? 'border-teal-600 text-teal-700' : 'border-transparent text-slate-500 hover:text-slate-700'" class="border-b-2 px-1 py-3 text-sm font-semibold transition">
                    Visao geral
                </button>
                <button type="button" @click="tab = 'checks'" :class="tab === 'checks' ? 'border-teal-600 text-teal-700' : 'border-transparent text-slate-500 hover:text-slate-700'" class="border-b-2 px-1 py-3 text-sm font-semibold transition">
                    Historico de checks
                </button>
                <button type="button" @click="tab = 'incidents'" :class="tab === 'incidents' ? 'border-teal-600 text-teal-700' : 'border-transparent text-slate-500 hover:text-slate-700'" class="border-b-2 px-1 py-3 text-sm font-semibold transition">
                    Incidentes
                </button>
            </nav>
        </div>

        <div x-show="tab === 'overview'" x-cloak class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-lg font-bold text-slate-950">Resumo operacional</h3>
                <p class="mt-2 text-sm text-slate-500">Area preparada para graficos de latencia e disponibilidade quando os workers estiverem ativos.</p>
                <div class="mt-5 h-40 rounded-lg bg-[linear-gradient(135deg,_#f8fafc_0%,_#dbeafe_45%,_#ccfbf1_100%)]"></div>
            </div>
            <div class="rounded-lg border border-slate-200 bg-slate-950 p-5 text-white shadow-sm">
                <h3 class="text-lg font-bold">Alertas configurados</h3>
                <p class="mt-2 text-sm text-slate-300">Email e Telegram serao disparados na Etapa 5 do roadmap.</p>
                <a href="{{ route('settings.alerts') }}" class="mt-5 inline-flex text-sm font-semibold text-teal-300 hover:text-teal-200">Configurar canais</a>
            </div>
        </div>

        <div x-show="tab === 'checks'" x-cloak class="rounded-lg border border-slate-200 bg-white shadow-sm overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-xs font-bold uppercase text-slate-500">
                    <tr>
                        <th class="px-5 py-3 text-start">Horario</th>
                        <th class="px-5 py-3 text-start">Status</th>
                        <th class="px-5 py-3 text-start">HTTP</th>
                        <th class="px-5 py-3 text-start">Latencia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($checks as $check)
                        <tr>
                            <td class="px-5 py-4 text-slate-600">{{ $check->checked_at->format('d/m H:i:s') }}</td>
                            <td class="px-5 py-4"><x-infrawatch.status-badge :status="$check->is_up ? 'online' : 'offline'" /></td>
                            <td class="px-5 py-4 text-slate-600">{{ $check->status_code ?? '—' }}</td>
                            <td class="px-5 py-4 text-slate-600">{{ $check->response_time_ms ? $check->response_time_ms.' ms' : '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-slate-500">Nenhum check registrado ainda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div x-show="tab === 'incidents'" x-cloak>
            @if (count($incidents) === 0)
                <x-infrawatch.empty-state
                    title="Sem incidentes para este monitor"
                    description="Quando o worker detectar falhas consecutivas, os incidentes aparecerao aqui."
                />
            @else
                <div class="space-y-4">
                    @foreach ($incidents as $incident)
                        <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-bold text-slate-950">Incidente #{{ $incident->id }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $incident->started_at->format('d/m/Y H:i') }} · {{ $incident->duration_seconds ? $incident->duration_seconds.'s' : 'em andamento' }}</p>
                                </div>
                                <x-infrawatch.status-badge :status="$incident->status" />
                            </div>
                            <p class="mt-3 text-sm text-slate-600">{{ $incident->error_message ?? 'Falha detectada pelo monitor.' }}</p>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
