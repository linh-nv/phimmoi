<?php
namespace App\Repositories\Category;

use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryRepositoryInterface
{
    public function getSearch(string $keyword): LengthAwarePaginator;
}
