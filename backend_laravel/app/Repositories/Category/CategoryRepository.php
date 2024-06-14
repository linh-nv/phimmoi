<?php

namespace App\Repositories\Category;

use App\Repositories\BaseRepository;
use App\Util\Constains;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\Category::class;
    }

    public function getSearch(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['title', 'slug', 'description', 'status'];

        return $this->search($searchFields, $keyword);
    }
}
