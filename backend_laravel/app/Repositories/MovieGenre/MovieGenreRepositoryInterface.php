<?php
namespace App\Repositories\MovieGenre;

use Illuminate\Support\Collection;

interface MovieGenreRepositoryInterface
{
    public function getMovies(int $genreId): Collection;
}
