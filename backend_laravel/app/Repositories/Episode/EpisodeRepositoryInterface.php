<?php
namespace App\Repositories\Episode;

use Illuminate\Pagination\LengthAwarePaginator;

interface EpisodeRepositoryInterface
{
    public function getEpisodesByMovie(string $movie_id): LengthAwarePaginator;
    public function getSearch(string $keyword): LengthAwarePaginator;
}
