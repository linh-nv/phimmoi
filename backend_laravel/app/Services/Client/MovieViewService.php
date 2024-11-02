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

    public function getAll(): ?Collection
    {
        $moviesDay = $this->moviesDay();
        $moviesWeek = $this->moviesWeek();
        $moviesMonth = $this->moviesMonth();
        $moviesYear = $this->moviesYear();


        $movies = collect([
            'day' => $moviesDay,
            'week' => $moviesWeek,
            'month' => $moviesMonth,
            'year' => $moviesYear,
        ]);

        return $movies;
    }

    public function moviesDay(): ?Collection
    {
        $movieIds = $this->movieViewRepository->getMoviesDay();
        $movie = $this->movieRepository->moviesByIds($movieIds);

        return $movie;
    }

    public function moviesWeek(): ?Collection
    {
        $movieIds = $this->movieViewRepository->getMoviesWeek();
        $movie = $this->movieRepository->moviesByIds($movieIds);

        return $movie;
    }

    public function moviesMonth(): ?Collection
    {
        $movieIds = $this->movieViewRepository->getMoviesMonth();
        $movie = $this->movieRepository->moviesByIds($movieIds);

        return $movie;
    }

    public function moviesYear(): ?Collection
    {
        $movieIds = $this->movieViewRepository->getMoviesYear();
        $movie = $this->movieRepository->moviesByIds($movieIds);

        return $movie;
    }

    public function createView(int $movieId): void
    {
        $movie = $this->movieRepository->find($movieId);
        $this->movieRepository->update($movie, ['view' => ++$movie->view]);
        $this->movieViewRepository->createView($movieId);
    }
}
