<?php

namespace App\Enums;

enum MovieQuality: int
{
    case CAM = 1;
    case FHD = 2;
    case HD = 3;
    
    public function label(): string
    {
        return match ($this) {
            MovieQuality::CAM => 'Cam',
            MovieQuality::FHD => 'FHD',
            MovieQuality::HD => 'HD',
        };
    }
    
    public static function labelFromValue(int $value): string
    {
        return match ($value) {
            self::CAM->value => self::CAM->label(),
            self::FHD->value => self::FHD->label(),
            self::HD->value => self::HD->label(),
            default => 'Unknown',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
