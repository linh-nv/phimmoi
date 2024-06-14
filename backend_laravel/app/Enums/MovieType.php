<?php

namespace App\Enums;

enum MovieType: int
{
    case SERIES = 1;
    case SINGER = 2;
    case TVSHOWS = 3;

    public function label(): string
    {
        return match ($this) {
            MovieType::SERIES => 'series',
            MovieType::SINGER => 'single',
            MovieType::TVSHOWS => 'tvshows',
        };
    }
    
    public static function labelFromValue(int $value): string
    {
        return match ($value) {
            self::SERIES->value => self::SERIES->label(),
            self::SINGER->value => self::SINGER->label(),
            self::TVSHOWS->value => self::TVSHOWS->label(),
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}