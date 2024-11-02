<?php

namespace App\Repositories\Genre;

use App\Models\Genre;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class GenreRepository extends BaseRepository implements GenreRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\Genre::class;
    }

    public function getSearch(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['title', 'slug', 'description', 'status'];

        return $this->search($searchFields, $keyword);
    }

    public function pluckTitle(): Collection
    {

        return $this->_model->pluck('title', 'id');
    }

    public function getBySlug(string $slug): Genre
    {

        return $this->_model->where('slug', $slug)->firstOrFail();
    }

    public function pluckSlugTitle(): Collection
    {

        return $this->_model->pluck('title', 'slug');
    }
}
