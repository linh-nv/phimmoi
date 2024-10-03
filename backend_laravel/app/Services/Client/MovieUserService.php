<?php

namespace App\Services\Client;

use App\Models\MovieUser;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\MovieUser\MovieUserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

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

    public function create(int $movieId): MovieUser
    {
        $user = Auth::guard('api')->user();

        $movieUser = [
            'movie_id' => $movieId,
            'user_id' => $user->id,
        ];

        return $this->movieUserRepository->updateOrCreate(conditions: ['movie_id' => $movieId], value: $movieUser);
    }

    public function exist(int $movieId): bool
    {
        $user = Auth::guard('api')->user();

        if ($this->movieUserRepository->findByMovieUser(movieId: $movieId, userId: $user->id)) {

            return true;
        }

        return false;
    }
}
