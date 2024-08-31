<?php

namespace App\Repositories\MovieUser;

use App\Repositories\BaseRepository;
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
}