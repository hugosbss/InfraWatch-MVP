<?php

namespace App\Livewire\Monitors;

use App\Models\Monitor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Show extends Component
{
    public Monitor $monitor;

    public string $activeTab = 'overview';

    public function togglePause(): void
    {
        $this->monitor->update([
            'status' => $this->monitor->status === 'paused' ? 'active' : 'paused',
        ]);

        $this->monitor->refresh();
    }

    public function mount(string $monitor): void
    {
        $this->monitor = Monitor::query()
            ->where('user_id', Auth::id())
            ->findOrFail($monitor);
    }

    public function render()
    {
        $checks = $this->monitor->logs()
            ->latest('checked_at')
            ->limit(20)
            ->get();

        $incidents = $this->monitor->incidents()
            ->latest('started_at')
            ->get();

        return view('livewire.monitors.show', [
            'checks' => $checks,
            'incidents' => $incidents,
            'latestLog' => $checks->first(),
        ]);
    }
}
