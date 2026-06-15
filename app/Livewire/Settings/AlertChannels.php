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

        $this->emailEnabled = (bool) ($user?->alert_email_enabled ?? true);
        $this->emailAddress = $user?->alertEmailAddress() ?? '';
        $this->telegramEnabled = (bool) ($user?->alert_telegram_enabled ?? false);
        $this->telegramChatId = $user?->alert_telegram_chat_id ?? '';
        $this->notifyOffline = (bool) ($user?->alert_notify_offline ?? true);
        $this->notifyRecovery = (bool) ($user?->alert_notify_recovery ?? true);
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

        auth()->user()->forceFill([
            'alert_email_enabled' => $this->emailEnabled,
            'alert_email_address' => $this->emailEnabled ? $this->emailAddress : null,
            'alert_telegram_enabled' => $this->telegramEnabled,
            'alert_telegram_chat_id' => $this->telegramEnabled ? $this->telegramChatId : null,
            'alert_notify_offline' => $this->notifyOffline,
            'alert_notify_recovery' => $this->notifyRecovery,
        ])->save();

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.settings.alert-channels');
    }
}
