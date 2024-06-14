<?php
namespace App\Repositories\Category;

use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function search(string $keyword): Collection;

}
