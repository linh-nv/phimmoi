<?php

namespace App\Services\Client;

use App\Repositories\Movie\MovieRepository;
use App\Repositories\MovieView\MovieViewRepository;
use Illuminate\Support\Collection;

class MovieViewService
{
    protected $movieRepository;
    protected $movieViewRepository;

    public function __construct(MovieRepository $movieRepository, MovieViewRepository $movieViewRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->movieViewRepository = $movieViewRepository;
    }

    public function moviesDay(): Collection
    {
        $movieIds = $this->movieViewRepository->getMoviesDay();
        $movie = $this->movieRepository->moviesByIds($movieIds);

        return $movie;
    }

    public function moviesWeek(): Collection
    {
        $movieIds = $this->movieViewRepository->getMoviesWeek();
        $movie = $this->movieRepository->moviesByIds($movieIds);

        return $movie;
    }

    public function moviesMonth(): Collection
    {
        $movieIds = $this->movieViewRepository->getMoviesMonth();
        $movie = $this->movieRepository->moviesByIds($movieIds);

        return $movie;
    }

    public function moviesYear(): Collection
    {
        $movieIds = $this->movieViewRepository->getMoviesYear();
        $movie = $this->movieRepository->moviesByIds($movieIds);

        return $movie;
    }
}
