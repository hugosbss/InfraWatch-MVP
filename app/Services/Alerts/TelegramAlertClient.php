<?php

namespace App\Services\Alerts;

use App\Models\Incident;

class TelegramAlertClient
{
    public function sendOffline(Incident $incident, ?string $chatId): bool
    {
        return false;
    }

    public function sendRecovered(Incident $incident, ?string $chatId): bool
    {
        return false;
    }
}
