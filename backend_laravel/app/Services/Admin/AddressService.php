<?php

namespace App\Services\Admin;

use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Repositories\Address\AddressRepository;
use App\Singletons\ResourceSingleton;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AddressService
{
    protected AddressRepository $addressRepository;
    protected $resourceSingleton;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
        $this->resourceSingleton = ResourceSingleton::getInstance();
    }

    public function getAll(?string $keyword = null): Collection
    {
        $address = $keyword ? $this->addressRepository->getSearch($keyword) : $this->addressRepository->getAll();
    
        return $address;
    }

    public function getPaginate(?string $keyword = null): LengthAwarePaginator
    {
        $address = $keyword ? $this->addressRepository->getSearch($keyword) : $this->addressRepository->getPaginate();

        return $address;
    }

    public function createAddress(array $data): Address
    {

        return $this->addressRepository->create([
            'user_id' => $data['user_id'],
            'address' => $data['address'],
            'province_id' => $data['province_id'],
            'district_id' => $data['district_id'],
            'ward_id' => $data['ward_id'],
            'created_at' => Carbon::now(),
        ]);
    }

    public function getAddressById(Address $address)
    {
        $address = $this->addressRepository->find($address);
        $this->addressRepository->loadRelationship($address);

        return $this->resourceSingleton->getResource(AddressResource::class, $address);
    }

    public function updateAddress(Address $address, array $data): Address
    {

        return $this->addressRepository->update($address, [
            'user_id' => $data['user_id'],
            'address' => $data['address'],
            'province_id' => $data['province_id'],
            'district_id' => $data['district_id'],
            'ward_id' => $data['ward_id'],
            'updated_at' => Carbon::now(),
        ]);
    }

    public function deleteAddress(Address $address): bool
    {

        return $this->addressRepository->delete($address);
    }

    public function destroyMultiple(array $ids): bool
    {

        return $this->addressRepository->destroy($ids);
    }
}
