<?php

namespace App\Enums;

enum ProvinceType: int
{
    case CITY = 1;
    case PROVINCE = 2;

    public function label(): string
    {
        return match ($this) {
            ProvinceType::CITY => 'Thành phố Trung ương',
            ProvinceType::PROVINCE => 'Tỉnh',
        };
    }
    
    public static function labelFromValue(int $value): string
    {
        return match ($value) {
            self::CITY->value => self::CITY->label(),
            self::PROVINCE->value => self::PROVINCE->label(),
            default => 'Unknown',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
