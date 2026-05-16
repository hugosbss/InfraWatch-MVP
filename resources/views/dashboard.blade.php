<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-teal-700">Centro de operacao</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-950">Dashboard InfraWatch</h1>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-full border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-600">MVP frontend</span>
                <span class="rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-sm font-semibold text-emerald-700">Auth ativo</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="grid gap-4 md:grid-cols-4">
                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Uptime medio</p>
                    <div class="mt-3 flex items-end justify-between">
                        <span class="text-3xl font-bold text-slate-950">99.98%</span>
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">estavel</span>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Monitoramentos</p>
                    <div class="mt-3 flex items-end justify-between">
                        <span class="text-3xl font-bold text-slate-950">0</span>
                        <span class="text-xs font-semibold text-slate-400">proxima etapa</span>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Incidentes abertos</p>
                    <div class="mt-3 flex items-end justify-between">
                        <span class="text-3xl font-bold text-slate-950">0</span>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">limpo</span>
                    </div>
                </div>

                <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-sm font-medium text-slate-500">Latencia media</p>
                    <div class="mt-3 flex items-end justify-between">
                        <span class="text-3xl font-bold text-slate-950">-- ms</span>
                        <span class="text-xs font-semibold text-slate-400">sem coletas</span>
                    </div>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-[1.35fr_.65fr]">
                <div class="rounded-lg border border-slate-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-3 border-b border-slate-200 p-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-lg font-bold text-slate-950">Visao de monitoramento</h2>
                            <p class="mt-1 text-sm text-slate-500">Area preparada para HTTP/HTTPS, ping e historico de checks.</p>
                        </div>
                        <button class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800" type="button">
                            Novo monitor
                        </button>
                    </div>

                    <div class="p-5">
                        <div class="overflow-hidden rounded-lg border border-slate-200">
                            <div class="grid grid-cols-4 bg-slate-50 px-4 py-3 text-xs font-bold uppercase text-slate-500">
                                <span>Servico</span>
                                <span>Status</span>
                                <span>Resposta</span>
                                <span>Ultimo check</span>
                            </div>

                            <div class="grid grid-cols-4 items-center px-4 py-4 text-sm">
                                <div class="font-semibold text-slate-900">Site institucional</div>
                                <div><span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">online</span></div>
                                <div class="text-slate-600">142 ms</div>
                                <div class="text-slate-500">simulado</div>
                            </div>

                            <div class="grid grid-cols-4 items-center border-t border-slate-100 px-4 py-4 text-sm">
                                <div class="font-semibold text-slate-900">API principal</div>
                                <div><span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">aguardando</span></div>
                                <div class="text-slate-600">--</div>
                                <div class="text-slate-500">proxima etapa</div>
                            </div>
                        </div>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                        <h2 class="text-lg font-bold text-slate-950">Perfil do usuario</h2>
                        <div class="mt-4 flex items-center gap-3">
                            <img class="size-14 rounded-full object-cover ring-4 ring-teal-50" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">
                            <div class="min-w-0">
                                <p class="truncate font-semibold text-slate-950">{{ Auth::user()->name }}</p>
                                <p class="truncate text-sm text-slate-500">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <a href="{{ route('profile.show') }}" class="mt-5 inline-flex w-full items-center justify-center rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Editar perfil e foto
                        </a>
                    </div>

                    <div class="rounded-lg border border-slate-200 bg-slate-950 p-5 text-white shadow-sm">
                        <h2 class="text-lg font-bold">Proximo marco</h2>
                        <p class="mt-2 text-sm text-slate-300">Criar CRUD de monitoramentos com Livewire, PostgreSQL e checks em fila.</p>
                        <div class="mt-5 h-2 overflow-hidden rounded-full bg-slate-800">
                            <div class="h-full w-1/4 rounded-full bg-teal-400"></div>
                        </div>
                    </div>
                </aside>
            </section>
        </div>
    </div>
</x-app-layout>
