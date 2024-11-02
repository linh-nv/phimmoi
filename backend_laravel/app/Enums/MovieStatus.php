<?php

namespace App\Enums;

enum MovieStatus: int
{
    case UNKNOWN = 0;
    case ONGOING = 1;
    case COMPLETED = 2;
    case TRAILER = 3;

    public function label(): string
    {

        return match ($this) {
            MovieStatus::UNKNOWN => 'unknown',
            MovieStatus::ONGOING => 'ongoing',
            MovieStatus::COMPLETED => 'completed',
            MovieStatus::TRAILER => 'trailer',
        };
    }

    public static function labelFromValue(int $value): string
    {

        return match ($value) {
            self::ONGOING->value => self::ONGOING->label(),
            self::COMPLETED->value => self::COMPLETED->label(),
            self::TRAILER->value => self::TRAILER->label(),
            default => self::UNKNOWN->label(),
        };
    }

    public static function valueFromLable(string $lable): int
    {

        return match ($lable) {
            self::ONGOING->label() => self::ONGOING->value,
            self::COMPLETED->label() => self::COMPLETED->value,
            self::TRAILER->label() => self::TRAILER->value,
            default => self::UNKNOWN->value,
        };
    }

    public static function values(): array
    {

        return array_column(self::cases(), 'name', 'value');
    }
}
