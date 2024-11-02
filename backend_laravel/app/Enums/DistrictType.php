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
    
    public static function labelFromValue(int $value): string
    {
        return match ($value) {
            self::HUYEN->value => self::HUYEN->label(),
            self::QUAN->value => self::QUAN->label(),
            self::THI_XA->value => self::THI_XA->label(),
            default => 'Unknown',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}