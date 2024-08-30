<?php

namespace App\Services\Client;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Movie\MovieRepository;
use Illuminate\Support\Collection;

class HomeService
{
    protected $movieRepository;
    protected $categoryRepository;

    public function __construct(MovieRepository $movieRepository, CategoryRepository $categoryRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): Collection
    {
        $movies = $this->getMovies();

        return $movies;
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
}