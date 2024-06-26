<?php

namespace App\Enums;

enum Status: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    public function label(): string
    {
        return match ($this) {
            Status::INACTIVE => 'Inactive',
            Status::ACTIVE => 'Active',
        };
    }
    
    public static function labelFromValue(int $value): string
    {
        return match ($value) {
            self::INACTIVE->value => self::INACTIVE->label(),
            self::ACTIVE->value => self::ACTIVE->label(),
            default => 'Unknown',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
