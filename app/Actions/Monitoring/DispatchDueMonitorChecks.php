<?php

namespace App\Actions\Monitoring;

use App\Jobs\CheckMonitorJob;
use App\Models\Monitor;

class DispatchDueMonitorChecks
{
    public function __invoke(): void
    {
        $minute = now()->minute;

        Monitor::query()
            ->active()
            ->http()
            ->chunkById(100, function ($monitors) use ($minute) {
                $monitors
                    ->filter(fn (Monitor $monitor) => $monitor->isDueForCheck($minute))
                    ->each(fn (Monitor $monitor) => CheckMonitorJob::dispatch($monitor->id));
            });
    }
}
