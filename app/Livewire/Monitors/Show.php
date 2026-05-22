<?php

namespace App\Livewire\Monitors;

use App\Support\MonitoringDemoData;
use Livewire\Component;

class Show extends Component
{
    public array $monitor;

    public string $activeTab = 'overview';

    public function mount(string $monitor): void
    {
        $data = MonitoringDemoData::findMonitor($monitor);

        if ($data === null) {
            abort(404);
        }

        $this->monitor = $data;
    }

    public function render()
    {
        return view('livewire.monitors.show', [
            'checks' => [
                ['at' => '14:35', 'status' => $this->monitor['status'], 'code' => 200, 'ms' => $this->monitor['response_ms'] ?? null],
                ['at' => '14:34', 'status' => 'online', 'code' => 200, 'ms' => 156],
                ['at' => '14:33', 'status' => 'online', 'code' => 200, 'ms' => 149],
                ['at' => '14:32', 'status' => 'degraded', 'code' => 200, 'ms' => 812],
            ],
            'incidents' => collect(MonitoringDemoData::incidents())
                ->filter(fn (array $incident) => $incident['monitor'] === $this->monitor['name'])
                ->values()
                ->all(),
        ]);
    }
}
