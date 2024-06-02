<?php

namespace App\Enums;

enum WardType: string
{
    case XA = 'Xã';
    case PHUONG = 'Phường';
    case THI_TRAN = 'Thị trấn';

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
