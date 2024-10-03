<?php

namespace App\Repositories\MovieUser;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MovieUserRepository extends BaseRepository implements MovieUserRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\MovieUser::class;
    }

    public function getMovies(int $userId): ?Collection
    {

        return $this->_model
            ->where('user_id', $userId)
            ->pluck('movie_id');
    }

    public function findByMovieUser(int $movieId, int $userId): ?Model
    {

        return $this->_model->where('movie_id', $movieId)->where('user_id', $userId)->first();
    }
}
