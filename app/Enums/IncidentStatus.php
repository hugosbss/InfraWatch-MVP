<?php

namespace App\Enums;

enum IncidentStatus: string
{
    case Open = 'open';
    case Resolved = 'resolved';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::Open => 'aberto',
            self::Resolved => 'resolvido',
        };
    }
}
