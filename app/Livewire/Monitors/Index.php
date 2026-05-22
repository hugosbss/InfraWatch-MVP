<?php

namespace App\Livewire\Monitors;

use App\Support\MonitoringDemoData;
use Livewire\Component;

class Index extends Component
{
    public string $search = '';

    public string $statusFilter = 'all';

    public string $typeFilter = 'all';

    public function render()
    {
        $monitors = collect(MonitoringDemoData::monitors())
            ->when($this->search !== '', function ($collection) {
                $term = strtolower($this->search);

                return $collection->filter(function (array $monitor) use ($term) {
                    return str_contains(strtolower($monitor['name']), $term)
                        || str_contains(strtolower($monitor['target']), $term);
                });
            })
            ->when($this->statusFilter !== 'all', fn ($collection) => $collection->where('status', $this->statusFilter))
            ->when($this->typeFilter !== 'all', fn ($collection) => $collection->where('type', $this->typeFilter))
            ->values()
            ->all();

        return view('livewire.monitors.index', [
            'monitors' => $monitors,
        ]);
    }
}
