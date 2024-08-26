<?php

namespace App\Enums;

enum MovieType: int
{
    case UNKNOWN = 0;
    case SERIES = 1;
    case SINGER = 2;
    case TVSHOWS = 3;
    case HOATHINH = 4;

    public function label(): string
    {

        return match ($this) {
            MovieType::UNKNOWN => 'unknown',
            MovieType::SERIES => 'series',
            MovieType::SINGER => 'single',
            MovieType::TVSHOWS => 'tvshows',
            MovieType::HOATHINH => 'hoathinh',
        };
    }

    public static function labelFromValue(int $value): string
    {

        return match ($value) {
            self::SERIES->value => self::SERIES->label(),
            self::SINGER->value => self::SINGER->label(),
            self::TVSHOWS->value => self::TVSHOWS->label(),
            self::HOATHINH->value => self::HOATHINH->label(),
            default => self::UNKNOWN->label(),
        };
    }

    public static function valueFromLable(string $lable): int
    {

        return match ($lable) {
            self::SERIES->label() => self::SERIES->value,
            self::SINGER->label() => self::SINGER->value,
            self::TVSHOWS->label() => self::TVSHOWS->value,
            self::HOATHINH->label() => self::HOATHINH->value,
            default => self::UNKNOWN->value,
        };
    }

    public static function values(): array
    {

        return array_column(self::cases(), 'name', 'value');
    }
}
