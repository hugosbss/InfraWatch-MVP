<?php

namespace App\Livewire\Monitors;

use App\Enums\MonitorStatus;
use App\Models\Monitor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    public string $statusFilter = 'all';

    public string $typeFilter = 'all';

    public function togglePause(int $monitorId): void
    {
        $this->findMonitor($monitorId)->toggleStatus();
    }

    public function delete(int $monitorId): void
    {
        $this->findMonitor($monitorId)->delete();
    }

    public function render()
    {
        $monitors = Monitor::query()
            ->where('user_id', Auth::id())
            ->with('latestLog')
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('target', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->hasStatusFilter(), fn ($query) => $query->where('status', $this->statusFilter))
            ->when($this->typeFilter !== 'all', fn ($query) => $query->where('type', $this->typeFilter))
            ->latest()
            ->get();

        return view('livewire.monitors.index', [
            'monitors' => $monitors,
        ]);
    }

    private function findMonitor(int $monitorId): Monitor
    {
        return Monitor::query()
            ->where('user_id', Auth::id())
            ->findOrFail($monitorId);
    }

    private function hasStatusFilter(): bool
    {
        return in_array($this->statusFilter, MonitorStatus::values(), true);
    }
}
