<?php

namespace App\Actions\Alerts;

use App\Mail\IncidentOfflineMail;
use App\Mail\IncidentRecoveredMail;
use App\Models\Incident;
use App\Services\Alerts\TelegramAlertClient;
use Illuminate\Support\Facades\Mail;

class DispatchIncidentAlerts
{
    public function __construct(private readonly TelegramAlertClient $telegram) {}

    public function offline(Incident $incident): void
    {
        $incident->loadMissing('monitor.user');

        $user = $incident->monitor->user;

        if (! $user->alert_notify_offline) {
            return;
        }

        if ($user->alert_email_enabled && $incident->offline_email_sent_at === null) {
            Mail::to($user->alertEmailAddress())->queue(new IncidentOfflineMail($incident));

            $incident->forceFill(['offline_email_sent_at' => now()])->save();
        }

        if ($user->alert_telegram_enabled && $incident->offline_telegram_sent_at === null) {
            if ($this->telegram->sendOffline($incident, $user->alert_telegram_chat_id)) {
                $incident->forceFill(['offline_telegram_sent_at' => now()])->save();
            }
        }
    }

    public function recovered(Incident $incident): void
    {
        $incident->loadMissing('monitor.user');

        $user = $incident->monitor->user;

        if (! $user->alert_notify_recovery) {
            return;
        }

        if ($user->alert_email_enabled && $incident->recovery_email_sent_at === null) {
            Mail::to($user->alertEmailAddress())->queue(new IncidentRecoveredMail($incident));

            $incident->forceFill(['recovery_email_sent_at' => now()])->save();
        }

        if ($user->alert_telegram_enabled && $incident->recovery_telegram_sent_at === null) {
            if ($this->telegram->sendRecovered($incident, $user->alert_telegram_chat_id)) {
                $incident->forceFill(['recovery_telegram_sent_at' => now()])->save();
            }
        }
    }
}
