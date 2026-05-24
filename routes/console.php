<?php

use App\Actions\Monitoring\DispatchDueMonitorChecks;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(fn () => app(DispatchDueMonitorChecks::class)())
    ->everyMinute()
    ->name('dispatch-due-monitor-checks')
    ->withoutOverlapping();
