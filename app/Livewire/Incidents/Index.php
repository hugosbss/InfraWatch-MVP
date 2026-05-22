<?php

namespace App\Livewire\Incidents;

use App\Support\MonitoringDemoData;
use Livewire\Component;

class Index extends Component
{
    public string $statusFilter = 'all';

    public function render()
    {
        $incidents = collect(MonitoringDemoData::incidents())
            ->when($this->statusFilter !== 'all', fn ($collection) => $collection->where('status', $this->statusFilter))
            ->values()
            ->all();

        $openCount = collect(MonitoringDemoData::incidents())->where('status', 'open')->count();

        return view('livewire.incidents.index', [
            'incidents' => $incidents,
            'openCount' => $openCount,
        ]);
    }
}
