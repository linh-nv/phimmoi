<?php
namespace App\Repositories\MovieUser;

use Illuminate\Support\Collection;

interface MovieUserRepositoryInterface
{
    public function getMovies(int $userId): ?Collection;
}
