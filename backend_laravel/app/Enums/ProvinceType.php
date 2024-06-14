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

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
