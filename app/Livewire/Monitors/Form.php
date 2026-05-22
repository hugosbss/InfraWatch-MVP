<?php

namespace App\Livewire\Monitors;

use App\Support\MonitoringDemoData;
use Livewire\Component;

class Form extends Component
{
    public ?string $monitorId = null;

    public string $name = '';

    public string $target = '';

    public string $type = 'https';

    public string $frequency = '5';

    public int $timeout = 10;

    public bool $isActive = true;

    public bool $saved = false;

    public function mount(?string $monitor = null): void
    {
        $this->monitorId = $monitor;

        if ($monitor === null) {
            return;
        }

        $existing = MonitoringDemoData::findMonitor($monitor);

        if ($existing === null) {
            abort(404);
        }

        $this->name = $existing['name'];
        $this->target = $existing['target'];
        $this->type = $existing['type'];
        $this->frequency = match ($existing['frequency']) {
            '1 min' => '1',
            default => '5',
        };
        $this->timeout = (int) $existing['timeout'];
        $this->isActive = $existing['status'] !== 'paused';
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:120'],
            'target' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:http,https,ping'],
            'frequency' => ['required', 'in:1,5'],
            'timeout' => ['required', 'integer', 'min:5', 'max:60'],
        ]);

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.monitors.form', [
            'isEditing' => $this->monitorId !== null,
        ]);
    }
}
