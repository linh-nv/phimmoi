<?php

namespace App\Services\Client;

use App\Http\Resources\MovieResource;
use App\Repositories\Movie\MovieRepository;
use App\Singletons\ResourceSingleton;
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
}