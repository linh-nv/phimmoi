<?php

namespace App\Enums;

enum MovieStatus: int
{
    case ONGOING = 1;
    case COMPLETE = 2;

    public function label(): string
    {
        return match ($this) {
            MovieStatus::ONGOING => 'ongoing',
            MovieStatus::COMPLETE => 'complete',
        };
    }
    
    public static function labelFromValue(int $value): string
    {
        return match ($value) {
            self::ONGOING->value => self::ONGOING->label(),
            self::COMPLETE->value => self::COMPLETE->label(),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
