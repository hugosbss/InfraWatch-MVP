<?php

namespace App\Models;

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
            'timeout' => 'integer',
        ];
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
