<?php

namespace App\Models;

use App\Enums\IncidentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'monitor_id',
        'started_at',
        'ended_at',
        'duration_seconds',
        'error_message',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'ended_at' => 'datetime',
            'duration_seconds' => 'integer',
            'status' => IncidentStatus::class,
        ];
    }

    public function isOpen(): bool
    {
        return $this->status === IncidentStatus::Open;
    }

    public function durationInSeconds(): int
    {
        if ($this->duration_seconds !== null) {
            return $this->duration_seconds;
        }

        return (int) $this->started_at->diffInSeconds($this->ended_at ?? now());
    }

    public function durationLabel(): string
    {
        $seconds = $this->durationInSeconds();

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

    public function monitor(): BelongsTo
    {
        return $this->belongsTo(Monitor::class);
    }
}
