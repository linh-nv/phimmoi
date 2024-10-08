<?php

namespace App\Repositories\Country;

use App\Models\Country;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\Country::class;
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

    public function getBySlug(string $slug): Country
    {

        return $this->_model->where('slug', $slug)->firstOrFail();
    }

    public function pluckSlugTitle(): Collection
    {

        return $this->_model->pluck('title', 'slug');
    }
}
