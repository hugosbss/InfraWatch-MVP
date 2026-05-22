<div class="py-8">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        @if ($saved)
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                Configuracao salva em modo demonstracao. A persistencia no banco sera adicionada na Etapa 2.
            </div>
        @endif

        <form wire:submit="save" class="space-y-6 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <x-label for="name" value="Nome do monitor" />
                    <x-input id="name" type="text" class="mt-1 block w-full" wire:model="name" placeholder="Ex: Site institucional" />
                    <x-input-error for="name" class="mt-2" />
                </div>

                <div class="sm:col-span-2">
                    <x-label for="target" value="Alvo (URL ou IP)" />
                    <x-input id="target" type="text" class="mt-1 block w-full" wire:model="target" placeholder="https://empresa.com.br ou 8.8.8.8" />
                    <x-input-error for="target" class="mt-2" />
                </div>

                <div>
                    <x-label for="type" value="Tipo de verificacao" />
                    <select id="type" wire:model="type" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="https">HTTPS</option>
                        <option value="http">HTTP</option>
                        <option value="ping">Ping (futuro)</option>
                    </select>
                    <x-input-error for="type" class="mt-2" />
                </div>

                <div>
                    <x-label for="frequency" value="Frequencia" />
                    <select id="frequency" wire:model="frequency" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                        <option value="1">A cada 1 minuto</option>
                        <option value="5">A cada 5 minutos</option>
                    </select>
                    <x-input-error for="frequency" class="mt-2" />
                </div>

                <div>
                    <x-label for="timeout" value="Timeout (segundos)" />
                    <x-input id="timeout" type="number" min="5" max="60" class="mt-1 block w-full" wire:model="timeout" />
                    <x-input-error for="timeout" class="mt-2" />
                </div>

                <div class="flex items-end">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="isActive" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" />
                        <span class="text-sm font-semibold text-slate-700">Monitor ativo</span>
                    </label>
                </div>
            </div>

            <div class="flex flex-col gap-3 border-t border-slate-200 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ $isEditing ? route('monitors.show', $monitorId) : route('monitors.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ $isEditing ? 'Salvar alteracoes' : 'Criar monitor' }}</span>
                    <span wire:loading>Salvando...</span>
                </button>
            </div>
        </form>
    </div>
</div>
