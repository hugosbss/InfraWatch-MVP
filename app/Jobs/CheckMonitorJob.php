<?php

namespace App\Jobs;

use App\Actions\Monitoring\CheckMonitor;
use App\Models\Monitor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckMonitorJob implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $monitorId) {}

    public function handle(CheckMonitor $checkMonitor): void
    {
        $monitor = Monitor::query()->find($this->monitorId);

        if ($monitor) {
            $checkMonitor($monitor);
        }
    }
}
