<?php
namespace App\Repositories\Category;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getSearch(string $keyword): LengthAwarePaginator;
    public function pluckTitle(): Collection;
}
