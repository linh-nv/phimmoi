<?php
namespace App\Repositories\MovieUser;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MovieUserRepositoryInterface
{
    public function getMovies(int $userId): ?Collection;
    public function findByMovieUser(int $movieId, int $userId): ?Model;
}
