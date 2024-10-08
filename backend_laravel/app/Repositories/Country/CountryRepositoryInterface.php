<?php

namespace App\Repositories\Country;

use App\Models\Country;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    public function getSearch(string $keyword): LengthAwarePaginator;
    public function pluckTitle(): Collection;
    public function getBySlug(string $slug): Country;
}
