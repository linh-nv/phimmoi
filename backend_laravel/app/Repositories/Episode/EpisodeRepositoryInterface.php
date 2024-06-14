<?php
namespace App\Repositories\Episode;

use Illuminate\Pagination\LengthAwarePaginator;

interface EpisodeRepositoryInterface
{
    public function getSearch(string $keyword): LengthAwarePaginator;
}
