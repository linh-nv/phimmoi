<?php

namespace App\Services;

use App\Enums\MovieQuality;
use App\Enums\MovieStatus;
use App\Enums\MovieType;
use App\Enums\Status;

class EnumService
{
    public function getAllEnums(): array
    {

        return [
            'quality' => $this->getMovieQuality(),
            'movie-status' => $this->getMovieStatus(),
            'type' => $this->getMovieType(),
            'status' => $this->getStatus()
        ];
    }

    public function getMovieQuality(): array
    {

        return MovieQuality::values();
    }

    public function getMovieStatus(): array
    {

        return MovieStatus::values();
    }

    public function getMovieType(): array
    {

        return MovieType::values();
    }

    public function getStatus(): array
    {

        return Status::values();
    }
}
