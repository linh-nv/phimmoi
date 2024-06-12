<?php

namespace App\Enums;

enum WardType: string
{
    case XA = 1;
    case PHUONG = 2;
    case THI_TRAN = 3;

    public function label(): string
    {
        return match ($this) {
            WardType::XA => 'Xã',
            WardType::PHUONG => 'Phường',
            WardType::THI_TRAN => 'Thị trấn',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
