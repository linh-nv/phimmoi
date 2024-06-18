<?php
namespace App\Repositories\Address;

use Illuminate\Pagination\LengthAwarePaginator;

interface AddressRepositoryInterface
{
    public function getSearch(string $keyword): LengthAwarePaginator;
}
