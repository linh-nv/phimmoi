<?php

namespace App\Repositories\Genre;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface GenreRepositoryInterface
{
    public function getSearch(string $keyword): LengthAwarePaginator;
    public function pluckTitle(): Collection;
}
