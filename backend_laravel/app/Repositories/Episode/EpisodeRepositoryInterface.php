<?php
namespace App\Repositories\Episode;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface EpisodeRepositoryInterface
{
    public function getEpisodesByMovie(string $movie_id): Collection;
    public function getSearch(string $keyword): LengthAwarePaginator;
}
