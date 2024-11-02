<?php

namespace App\Services\Admin;

use App\Models\Country;
use App\Repositories\Country\CountryRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use function App\Helpers\convert_to_slug;

class CountryService
{
    protected CountryRepository $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getAll(?string $keyword = null)
    {

        return $keyword ? $this->countryRepository->getSearch($keyword) : $this->countryRepository->getAll();
    }

    public function getPaginate(?string $keyword = null): LengthAwarePaginator
    {

        return $keyword ? $this->countryRepository->getSearch($keyword) : $this->countryRepository->getPaginate();
    }

    public function createCountry(array $data): Country
    {

        return $this->countryRepository->create([
            'title' => $data['title'],
            'slug' => convert_to_slug($data['slug']),
            'description' => $data['description'],
            'status' => $data['status'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    public function getCountryById(Country $country): Country
    {

        return $this->countryRepository->find($country);
    }

    public function updateCountry(Country $country, array $data): Country
    {

        return $this->countryRepository->update($country, [
            'title' => $data['title'],
            'slug' => convert_to_slug($data['slug']),
            'description' => $data['description'],
            'status' => $data['status'],
        ]);
    }

    public function deleteCountry(Country $country): bool
    {

        return $this->countryRepository->delete($country);
    }

    public function destroyMultiple(array $ids): bool
    {

        return $this->countryRepository->destroy($ids);
    }

    public function pluckTitle(): Collection
    {

        return $this->countryRepository->pluckTitle();
    }
}
