<?php

namespace App\Livewire\Monitors;

use App\Models\Monitor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Monitor $monitorModel;

    public string $activeTab = 'overview';

    public function togglePause(): void
    {
        $this->monitorModel->toggleStatus();
        $this->monitorModel->refresh();
    }

    public function mount(string $monitor): void
    {
        $this->monitorModel = Monitor::query()
            ->visibleToTeam(Auth::user()->currentTeam)
            ->with('user')
            ->findOrFail($monitor);
    }

    public function render()
    {
        $checks = $this->monitorModel->logs()
            ->latest('checked_at')
            ->limit(20)
            ->get();

        $incidents = $this->monitorModel->incidents()
            ->latest('started_at')
            ->get();

        return view('livewire.monitors.show', [
            'monitor' => $this->monitorModel,
            'checks' => $checks,
            'incidents' => $incidents,
            'latestLog' => $checks->first(),
        ]);
    }
}
