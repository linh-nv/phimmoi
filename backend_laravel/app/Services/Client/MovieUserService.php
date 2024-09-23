<?php

namespace App\Services\Client;

use App\Repositories\Movie\MovieRepository;
use App\Repositories\MovieUser\MovieUserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieUserService
{
    protected $movieRepository;
    protected $movieUserRepository;

    public function __construct(MovieRepository $movieRepository, MovieUserRepository $movieUserRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->movieUserRepository = $movieUserRepository;
    }

    public function getMovies(int $userId): ?LengthAwarePaginator
    {
        $movieIds = $this->movieUserRepository->getMovies($userId);
        $movies = $this->movieRepository->moviesLatestByIds($movieIds);

        return $movies;
    }
}
