<?php

namespace App\Enums;

enum DistrictType: int
{
    case HUYEN = 1;
    case QUAN = 2;
    case THI_XA = 3;

    public function label(): string
    {
        return match ($this) {
            DistrictType::HUYEN => 'Huyện',
            DistrictType::QUAN => 'Quận',
            DistrictType::THI_XA => 'Thị xã',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}