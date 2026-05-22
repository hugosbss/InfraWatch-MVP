<?php

namespace App\Livewire\Settings;

use Livewire\Component;

class AlertChannels extends Component
{
    public bool $emailEnabled = true;

    public string $emailAddress = '';

    public bool $telegramEnabled = false;

    public string $telegramChatId = '';

    public bool $notifyOffline = true;

    public bool $notifyRecovery = true;

    public bool $saved = false;

    public function mount(): void
    {
        $user = auth()->user();

        $this->emailAddress = $user?->email ?? '';
    }

    public function save(): void
    {
        $rules = [
            'emailEnabled' => ['boolean'],
            'telegramEnabled' => ['boolean'],
            'notifyOffline' => ['boolean'],
            'notifyRecovery' => ['boolean'],
        ];

        if ($this->emailEnabled) {
            $rules['emailAddress'] = ['required', 'email'];
        }

        if ($this->telegramEnabled) {
            $rules['telegramChatId'] = ['required', 'string', 'max:64'];
        }

        $this->validate($rules);

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.settings.alert-channels');
    }
}
