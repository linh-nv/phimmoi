<?php

namespace App\Repositories\Address;

use App\Repositories\BaseRepository;
use App\Repositories\Address\AddressRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\Address::class;
    }

    public function getSearch(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['user_id', 'address', 'province_id', 'district_id', 'ward_id'];

        return $this->search($searchFields, $keyword);
    }
}
