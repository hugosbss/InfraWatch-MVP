<?php

namespace App\Actions\Monitoring;

use App\Actions\Alerts\DispatchIncidentAlerts;
use App\Enums\IncidentStatus;
use App\Models\Incident;
use App\Models\Monitor;
use Illuminate\Support\Facades\Http;
use Throwable;

class CheckMonitor
{
    private const FAILURE_THRESHOLD = 3;

    public function __construct(private readonly DispatchIncidentAlerts $alerts) {}

    public function __invoke(Monitor $monitor): void
    {
        if (! $monitor->isActive() || $monitor->type !== 'http') {
            return;
        }

        $result = $this->checkHttp($monitor);

        $monitor->logs()->create([
            'status_code' => $result['status_code'],
            'response_time_ms' => $result['response_time_ms'],
            'is_up' => $result['is_up'],
            'checked_at' => now(),
        ]);

        $this->syncIncident($monitor, $result);
    }

    private function checkHttp(Monitor $monitor): array
    {
        $startedAt = hrtime(true);

        try {
            $response = Http::timeout($monitor->timeout)->get($monitor->target);

            return [
                'status_code' => $response->status(),
                'response_time_ms' => $this->elapsedMs($startedAt),
                'is_up' => $response->successful(),
                'error_message' => $response->successful() ? null : "HTTP {$response->status()}",
            ];
        } catch (Throwable $e) {
            return [
                'status_code' => null,
                'response_time_ms' => $this->elapsedMs($startedAt),
                'is_up' => false,
                'error_message' => $e->getMessage(),
            ];
        }
    }

    private function syncIncident(Monitor $monitor, array $result): void
    {
        $openIncident = $monitor->incidents()
            ->where('status', IncidentStatus::Open->value)
            ->first();

        if ($result['is_up']) {
            $this->resolveIncident($openIncident);

            return;
        }

        if ($openIncident) {
            $this->alerts->offline($openIncident);

            return;
        }

        if (! $this->hasConfirmedFailure($monitor)) {
            return;
        }

        $incident = $monitor->incidents()->create([
            'started_at' => now(),
            'error_message' => $result['error_message'],
            'status' => IncidentStatus::Open,
        ]);

        $this->alerts->offline($incident);
    }

    private function hasConfirmedFailure(Monitor $monitor): bool
    {
        $logs = $monitor->logs()
            ->latest('checked_at')
            ->limit(self::FAILURE_THRESHOLD)
            ->get();

        return $logs->count() === self::FAILURE_THRESHOLD
            && $logs->every(fn ($log) => ! $log->is_up);
    }

    private function resolveIncident(?Incident $incident): void
    {
        if (! $incident) {
            return;
        }

        $endedAt = now();

        $incident->update([
            'ended_at' => $endedAt,
            'duration_seconds' => $incident->started_at->diffInSeconds($endedAt),
            'status' => IncidentStatus::Resolved,
        ]);

        $this->alerts->recovered($incident->refresh());
    }

    private function elapsedMs(int $startedAt): int
    {
        return (int) ((hrtime(true) - $startedAt) / 1_000_000);
    }
}
