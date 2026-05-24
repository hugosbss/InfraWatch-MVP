<?php

namespace App\Enums;

enum MonitorStatus: string
{
    case Active = 'active';
    case Paused = 'paused';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Active => 'ativo',
            self::Paused => 'pausado',
        };
    }
}
