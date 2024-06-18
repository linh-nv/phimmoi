<?php

namespace App\Services;

use App\Models\Address;
use App\Repositories\Address\AddressRepository;
use Carbon\Carbon;

class AddressService
{
    protected AddressRepository $addressRepository;

    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function getAll(?string $keyword = null)
    {

        return $keyword ? $this->addressRepository->getSearch($keyword) : $this->addressRepository->getAll();
    }

    public function getPaginate(?string $keyword = null)
    {

        return $keyword ? $this->addressRepository->getSearch($keyword) : $this->addressRepository->getPaginate();
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

    public function getAddressById(Address $address): Address
    {

        return $this->addressRepository->find($address);
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
