<?php

namespace App\Services\Client;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Movie\MovieRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    protected $movieRepository;
    protected $categoryRepository;

    public function __construct(MovieRepository $movieRepository, CategoryRepository $categoryRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(string $slug): LengthAwarePaginator
    {
        $category = $this->categoryRepository->getBySlug($slug);
        $movies = $this->movieRepository->getMoviesByCategoryPaginate($category->id);

        return $movies;
    }
}