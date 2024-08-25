<?php

namespace App\Enums;

enum MovieQuality: int
{
    case UNKNOWN = 0;
    case CAM = 1;
    case FHD = 2;
    case HD = 3;

    public function label(): string
    {
        return match ($this) {
            MovieQuality::UNKNOWN => 'unknown',
            MovieQuality::CAM => 'cam',
            MovieQuality::FHD => 'fhd',
            MovieQuality::HD => 'hd',
        };
    }

    public static function labelFromValue(int $value): string
    {
        return match ($value) {
            self::CAM->value => self::CAM->label(),
            self::FHD->value => self::FHD->label(),
            self::HD->value => self::HD->label(),
            default => self::UNKNOWN->label(),
        };
    }

    public static function valueFromLable(string $lable): int
    {

        return match ($lable) {
            self::CAM->label() => self::CAM->value,
            self::FHD->label() => self::FHD->value,
            self::HD->label() => self::HD->value,
            default => self::UNKNOWN->value,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
