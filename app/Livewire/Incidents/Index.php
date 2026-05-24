<?php

namespace App\Livewire\Incidents;

use App\Enums\IncidentStatus;
use App\Models\Incident;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public string $statusFilter = 'all';

    public function render()
    {
        $userId = Auth::id();

        $baseQuery = Incident::query()
            ->whereHas('monitor', fn ($query) => $query->where('user_id', $userId));

        $incidents = (clone $baseQuery)
            ->with('monitor')
            ->when($this->hasStatusFilter(), fn ($query) => $query->where('status', $this->statusFilter))
            ->latest('started_at')
            ->get();

        $openCount = (clone $baseQuery)
            ->where('status', IncidentStatus::Open->value)
            ->count();

        $resolvedLastWeek = (clone $baseQuery)
            ->where('status', IncidentStatus::Resolved->value)
            ->where('ended_at', '>=', now()->subDays(7))
            ->count();

        $averageDuration = (clone $baseQuery)
            ->whereNotNull('duration_seconds')
            ->avg('duration_seconds');

        return view('livewire.incidents.index', [
            'incidents' => $incidents,
            'openCount' => $openCount,
            'resolvedLastWeek' => $resolvedLastWeek,
            'averageDuration' => $this->formatDuration($averageDuration),
        ]);
    }

    private function hasStatusFilter(): bool
    {
        return in_array($this->statusFilter, IncidentStatus::values(), true);
    }

    private function formatDuration(float|int|null $seconds): string
    {
        if ($seconds === null) {
            return '—';
        }

        $seconds = (int) round($seconds);

        if ($seconds < 60) {
            return "{$seconds}s";
        }

        $minutes = intdiv($seconds, 60);

        if ($minutes < 60) {
            return "{$minutes} min";
        }

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        return $remainingMinutes === 0
            ? "{$hours}h"
            : "{$hours}h {$remainingMinutes}min";
    }
}
