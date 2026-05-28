<?php

namespace App\Livewire\Dashboard;

use App\Enums\IncidentStatus;
use App\Models\Incident;
use App\Models\Monitor;
use App\Models\MonitorLog;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Overview extends Component
{
    public function render()
    {
        $team = Auth::user()->currentTeam;

        $allMonitors = Monitor::query()
            ->visibleToTeam($team)
            ->with(['latestLog', 'user'])
            ->latest()
            ->get();

        $monitors = $allMonitors->take(8);

        $incidents = Incident::query()
            ->whereHas('monitor', fn ($query) => $query->visibleToTeam($team))
            ->with(['monitor', 'monitor.user'])
            ->latest('started_at')
            ->limit(3)
            ->get();

        $checks = MonitorLog::query()
            ->whereHas('monitor', fn ($query) => $query->visibleToTeam($team))
            ->with('monitor')
            ->latest('checked_at')
            ->limit(6)
            ->get();

        $totalChecks = MonitorLog::query()
            ->whereHas('monitor', fn ($query) => $query->visibleToTeam($team))
            ->count();

        $upChecks = MonitorLog::query()
            ->whereHas('monitor', fn ($query) => $query->visibleToTeam($team))
            ->where('is_up', true)
            ->count();

        $averageLatency = MonitorLog::query()
            ->whereHas('monitor', fn ($query) => $query->visibleToTeam($team))
            ->whereNotNull('response_time_ms')
            ->avg('response_time_ms');

        $onlineCount = $allMonitors
            ->filter(fn (Monitor $monitor) => $monitor->operationalStatus() === 'online')
            ->count();

        $openIncidents = Incident::query()
            ->whereHas('monitor', fn ($query) => $query->visibleToTeam($team))
            ->where('status', IncidentStatus::Open->value)
            ->count();

        return view('livewire.dashboard.overview', [
            'monitors' => $monitors,
            'incidents' => $incidents,
            'checks' => $checks,
            'stats' => [
                'uptime' => $totalChecks > 0 ? number_format(($upChecks / $totalChecks) * 100, 2).'%' : '—',
                'monitors' => $allMonitors->count(),
                'online' => $onlineCount,
                'incidents' => $openIncidents,
                'latency' => $averageLatency !== null ? round($averageLatency).' ms' : '—',
            ],
        ]);
    }
}
