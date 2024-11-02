<?php

namespace App\Services\Admin;

use App\Enums\MovieQuality;
use App\Enums\MovieStatus;
use App\Enums\MovieType;
use App\Enums\Status;
use Illuminate\Support\Collection;

class EnumService
{
    public function getAllEnums(): Collection
    {

        return collect([
            'quality' => $this->getMovieQuality(),
            'movie-status' => $this->getMovieStatus(),
            'type' => $this->getMovieType(),
            'status' => $this->getStatus()
        ]);
    }

    public function getMovieQuality(): Collection
    {

        return collect(MovieQuality::values());
    }

    public function getMovieStatus(): Collection
    {

        return collect(MovieStatus::values());
    }

    public function getMovieType(): Collection
    {

        return collect(MovieType::values());
    }

    public function getStatus(): Collection
    {

        return collect(Status::values());
    }
}
