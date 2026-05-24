<?php

namespace App\Livewire\Incidents;

use App\Enums\IncidentStatus;
use App\Support\MonitoringDemoData;
use Livewire\Component;

class Index extends Component
{
    public string $statusFilter = 'all';

    public function render()
    {
        $incidents = collect(MonitoringDemoData::incidents())
            ->when($this->hasStatusFilter(), fn ($collection) => $collection->where('status', $this->statusFilter))
            ->values()
            ->all();

        $openCount = collect(MonitoringDemoData::incidents())->where('status', IncidentStatus::Open->value)->count();

        return view('livewire.incidents.index', [
            'incidents' => $incidents,
            'openCount' => $openCount,
        ]);
    }

    private function hasStatusFilter(): bool
    {
        return in_array($this->statusFilter, IncidentStatus::values(), true);
    }
}
