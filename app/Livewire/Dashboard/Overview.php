<?php

namespace App\Livewire\Dashboard;

use App\Support\MonitoringDemoData;
use Livewire\Component;

class Overview extends Component
{
    public function render()
    {
        $monitors = MonitoringDemoData::monitors();
        $incidents = MonitoringDemoData::incidents();
        $checks = MonitoringDemoData::recentChecks();

        $onlineCount = collect($monitors)->where('status', 'online')->count();
        $openIncidents = collect($incidents)->where('status', 'open')->count();

        return view('livewire.dashboard.overview', [
            'monitors' => $monitors,
            'incidents' => array_slice($incidents, 0, 3),
            'checks' => $checks,
            'stats' => [
                'uptime' => '99.12%',
                'monitors' => count($monitors),
                'online' => $onlineCount,
                'incidents' => $openIncidents,
                'latency' => '262 ms',
            ],
        ]);
    }
}
