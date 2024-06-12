<?php

namespace App\Enums;

enum MovieQuality: int
{
    case CAM = 1;
    case FHD = 2;
    case HD = 2;
    
    public function label(): string
    {
        return match ($this) {
            MovieQuality::CAM => 'Cam',
            MovieQuality::FHD => 'FHD',
            MovieQuality::HD => 'HD',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
