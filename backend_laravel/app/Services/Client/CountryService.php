<?php

namespace App\Services\Client;

use App\Repositories\Country\CountryRepository;
use App\Repositories\Movie\MovieRepository;
use Illuminate\Support\Collection;

class CountryService
{
    protected $movieRepository;
    protected $countryRepository;

    public function __construct(MovieRepository $movieRepository, CountryRepository $countryRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->countryRepository = $countryRepository;
    }

    public function index(string $slug): Collection
    {
        $country = $this->countryRepository->getBySlug($slug);
        $movies = $this->movieRepository->getMoviesByCountry($country->id);

        return $movies;
    }
}