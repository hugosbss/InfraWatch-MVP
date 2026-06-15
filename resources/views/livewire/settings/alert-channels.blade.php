<div class="py-8">
    <div class="mx-auto max-w-3xl space-y-6 px-4 sm:px-6 lg:px-8">
        @if ($saved)
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                Preferencias de alerta salvas.
            </div>
        @endif

        <form wire:submit="save" class="space-y-6">
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950">Email</h2>
                        <p class="mt-1 text-sm text-slate-500">Alertas de queda e recuperacao enviados pelo SMTP configurado.</p>
                    </div>
                    <label class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" wire:model.live="emailEnabled" class="peer sr-only" />
                        <span class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-teal-600 after:absolute after:start-[2px] after:top-[2px] after:size-5 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-full"></span>
                    </label>
                </div>

                @if ($emailEnabled)
                    <div class="mt-5">
                        <x-label for="emailAddress" value="Endereco de email" />
                        <x-input id="emailAddress" type="email" class="mt-1 block w-full" wire:model="emailAddress" />
                        <x-input-error for="emailAddress" class="mt-2" />
                    </div>
                @endif
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950">Telegram</h2>
                        <p class="mt-1 text-sm text-slate-500">Canal rapido para avisos de indisponibilidade (Etapa 5).</p>
                    </div>
                    <label class="relative inline-flex cursor-pointer items-center">
                        <input type="checkbox" wire:model.live="telegramEnabled" class="peer sr-only" />
                        <span class="h-6 w-11 rounded-full bg-slate-200 transition peer-checked:bg-teal-600 after:absolute after:start-[2px] after:top-[2px] after:size-5 after:rounded-full after:bg-white after:transition peer-checked:after:translate-x-full"></span>
                    </label>
                </div>

                @if ($telegramEnabled)
                    <div class="mt-5">
                        <x-label for="telegramChatId" value="Chat ID do Telegram" />
                        <x-input id="telegramChatId" type="text" class="mt-1 block w-full" wire:model="telegramChatId" placeholder="Ex: -1001234567890" />
                        <x-input-error for="telegramChatId" class="mt-2" />
                        <p class="mt-2 text-xs text-slate-500">O backend ja guarda o chat ID para a futura integracao com o bot.</p>
                    </div>
                @endif
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-950">Eventos de alerta</h2>
                <div class="mt-5 space-y-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="notifyOffline" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" />
                        <span class="text-sm font-semibold text-slate-700">Notificar quando o servico ficar offline</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="notifyRecovery" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" />
                        <span class="text-sm font-semibold text-slate-700">Notificar quando o servico voltar ao normal</span>
                    </label>
                </div>

                <div class="mt-6 rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                    <p class="font-semibold text-slate-900">Exemplo de mensagem</p>
                    <p class="mt-2 font-mono text-xs leading-relaxed text-slate-700">
                        Site offline<br>
                        Host: empresa.com.br<br>
                        Horario: 14:32<br>
                        Erro: timeout
                    </p>
                </div>
            </section>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800" wire:loading.attr="disabled">
                    Salvar configuracoes
                </button>
            </div>
        </form>
    </div>
</div>
