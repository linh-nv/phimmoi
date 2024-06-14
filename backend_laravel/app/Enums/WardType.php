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
    
    public static function labelFromValue(int $value): string
    {
        return match ($value) {
            self::XA->value => self::XA->label(),
            self::PHUONG->value => self::PHUONG->label(),
            self::THI_TRAN->value => self::THI_TRAN->label(),
            default => 'Unknown',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
