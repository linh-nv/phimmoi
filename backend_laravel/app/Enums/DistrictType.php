<?php

namespace App\Enums;

enum DistrictType: string
{
    case HUYEN = 'Huyện';
    case QUAN = 'Quận';
    case THI_XA = 'Thị xã';

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