<?php

namespace App\Services\Client;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Movie\MovieRepository;
use Illuminate\Support\Collection;

class CategoryService
{
    protected $movieRepository;
    protected $categoryRepository;

    public function __construct(MovieRepository $movieRepository, CategoryRepository $categoryRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(string $slug): Collection
    {
        $category = $this->categoryRepository->getBySlug($slug);
        $movies = $this->movieRepository->getMoviesByCategory($category->id);

        return $movies;
    }
}