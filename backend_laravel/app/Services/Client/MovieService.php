<?php

namespace App\Services\Client;

use App\Http\Resources\MovieResource;
use App\Repositories\Movie\MovieRepository;
use App\Singletons\ResourceSingleton;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MovieService
{
    protected $movieRepository;
    protected $resourceSingleton;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->resourceSingleton = ResourceSingleton::getInstance();
    }

    public function index(string $slug): MovieResource
    {
        $movie = $this->movieRepository->findBySlug($slug);
        $this->movieRepository->loadRelationship($movie);

        return $this->resourceSingleton->getResource(MovieResource::class, $movie);
    }

    public function search(string $keyword): ?Collection
    {
        $movie = $this->movieRepository->clientSearch($keyword);

        return $movie;
    }

    public function filter(Collection $data): LengthAwarePaginator
    {
        $filters = collect([
            'view' => $data['view'] ?? null,
            'update' => $data['update'] ?? null,
            'year' => $data['year'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'genre_id' => $data['genre_id'] ?? null,
            'country_id' => $data['country_id'] ?? null,
            'keyword' => $data['keyword'] ?? null,
        ]);
        $movies = $this->movieRepository->filterMovies($filters);

        return $movies;
    }
}
