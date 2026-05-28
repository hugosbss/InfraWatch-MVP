<x-action-section>
    <x-slot name="title">
        Excluir equipe
    </x-slot>

    <x-slot name="description">
        Exclua esta equipe permanentemente.
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            Ao excluir uma equipe, os dados vinculados a ela serao removidos permanentemente. Antes de continuar, confira se voce realmente deseja fazer isso.
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                Excluir equipe
            </x-danger-button>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <x-confirmation-modal wire:model.live="confirmingTeamDeletion">
            <x-slot name="title">
                Excluir equipe
            </x-slot>

            <x-slot name="content">
                Tem certeza que deseja excluir esta equipe? Esta acao nao pode ser desfeita.
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteTeam" wire:loading.attr="disabled">
                    Excluir equipe
                </x-danger-button>
            </x-slot>
        </x-confirmation-modal>
    </x-slot>
</x-action-section>
