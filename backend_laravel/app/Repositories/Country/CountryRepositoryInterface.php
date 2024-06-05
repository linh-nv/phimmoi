<?php
namespace App\Repositories\Country;

use Illuminate\Database\Eloquent\Collection;

interface CountryRepositoryInterface
{
    public function search(string $keyword): Collection;

}
