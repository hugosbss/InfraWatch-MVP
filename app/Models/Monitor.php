<?php

namespace App\Models;

use App\Enums\MonitorStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Monitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'target',
        'type',
        'frequency',
        'timeout',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => MonitorStatus::class,
            'timeout' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', MonitorStatus::Active->value);
    }

    public function scopeHttp(Builder $query): void
    {
        $query->where('type', 'http');
    }

    public function isActive(): bool
    {
        return $this->status === MonitorStatus::Active;
    }

    public function isPaused(): bool
    {
        return $this->status === MonitorStatus::Paused;
    }

    public function toggleStatus(): void
    {
        $this->update([
            'status' => $this->isPaused()
                ? MonitorStatus::Active
                : MonitorStatus::Paused,
        ]);
    }

    public function operationalStatus(): string
    {
        if ($this->isPaused()) {
            return MonitorStatus::Paused->value;
        }

        return match ($this->latestLog?->is_up) {
            true => 'online',
            false => 'offline',
            default => MonitorStatus::Active->value,
        };
    }

    public function isDueForCheck(int $minute): bool
    {
        return $this->frequency === '1m'
            || ($this->frequency === '5m' && $minute % 5 === 0);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(MonitorLog::class);
    }

    public function latestLog(): HasOne
    {
        return $this->hasOne(MonitorLog::class)->latestOfMany('checked_at');
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }
}
