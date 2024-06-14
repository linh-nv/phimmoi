<?php
namespace App\Repositories\Country;

use Illuminate\Pagination\LengthAwarePaginator;

interface CountryRepositoryInterface
{
    public function getSearch(string $keyword): LengthAwarePaginator;
}
