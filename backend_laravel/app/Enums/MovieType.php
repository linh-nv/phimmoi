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

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}