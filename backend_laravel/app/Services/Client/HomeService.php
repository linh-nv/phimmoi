<?php

namespace App\Services\Client;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Genre\GenreRepository;
use App\Repositories\Movie\MovieRepository;
use App\Util\Constants;
use Illuminate\Support\Collection;

class HomeService
{
    protected $movieRepository;
    protected $categoryRepository;
    protected $genreRepository;
    protected $countryRepository;

    public function __construct(MovieRepository $movieRepository, CategoryRepository $categoryRepository, GenreRepository $genreRepository, CountryRepository $countryRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->categoryRepository = $categoryRepository;
        $this->genreRepository = $genreRepository;
        $this->countryRepository = $countryRepository;
    }

    public function index(): Collection
    {
        $movies = $this->getMovies();

        return $movies;
    }

    public function header(): Collection
    {
        $categories = $this->categoryRepository->pluckSLugTitle();
        $genres = $this->genreRepository->pluckSLugTitle();
        $countries = $this->countryRepository->pluckSLugTitle();

        $header = collect([
            'categories' => $categories,
            'genres' => $genres,
            'countries' => $countries,
        ]);

        return $header;
    }

    public function slider(): ?Collection
    {
        $slider = $this->movieRepository->movieSummaryInformation();

        return $slider;
    }

    public function getMovies(): ?Collection
    {
        $categories = $this->categoryRepository->pluckTitle();
        $movies = collect();

        foreach ($categories as $key => $category) {
            $movies->put($category, $this->movieRepository->getMoviesByCategory($key));
        }

        return collect($movies);
    }

    public function filterOption(): Collection
    {
        $categories = $this->categoryRepository->pluckTitle();
        $genres = $this->genreRepository->pluckTitle();
        $countries = $this->countryRepository->pluckTitle();

        $filters = collect([
            'categories' => $categories,
            'genres' => $genres,
            'countries' => $countries,
        ]);

        return $filters;
    }
}
