<?php

namespace App\Repositories\MovieGenre;

use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class MovieGenreRepository extends BaseRepository implements MovieGenreRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\MovieGenre::class;
    }

    public function getMovies(int $genreId): Collection
    {

        return $this->_model         
        ->where('genre_id', $genreId)
        ->pluck('movie_id');
    }
}
