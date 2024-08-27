<?php

namespace App\Pipeline\CrawlMovies\Tasks;

use App\Repositories\Country\CountryRepository;
use App\Models\Country;

class GetCountry
{
    protected $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function execute(array $countryData): Country
    {
        return $this->countryRepository->firstOrCreate(['slug' => $countryData['slug']], ['title' => $countryData['name']]);
    }
}
