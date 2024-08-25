<?php

namespace App\Enums;

enum Status: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    public function label(): string
    {

        return match ($this) {
            Status::INACTIVE => 'inactive',
            Status::ACTIVE => 'active',
        };
    }

    public static function labelFromValue(int $value): string
    {

        return match ($value) {
            self::INACTIVE->value => self::INACTIVE->label(),
            self::ACTIVE->value => self::ACTIVE->label(),
            default => self::INACTIVE->label(),
        };
    }

    public static function valueFromLable(string $lable): int
    {

        return match ($lable) {
            self::INACTIVE->label() => self::INACTIVE->value,
            self::ACTIVE->label() => self::ACTIVE->value,
            default => self::INACTIVE->value,
        };
    }

    public static function values(): array
    {

        return array_column(self::cases(), 'name', 'value');
    }
}
