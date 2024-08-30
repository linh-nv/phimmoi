<?php

namespace App\Services\Client;

use App\Repositories\Genre\GenreRepository;
use App\Repositories\Movie\MovieRepository;
use App\Repositories\MovieGenre\MovieGenreRepository;
use Illuminate\Support\Collection;

class GenreService
{
    protected $movieRepository;
    protected $genreRepository;
    protected $movieGenreRepository;

    public function __construct(MovieRepository $movieRepository, GenreRepository $genreRepository, MovieGenreRepository $movieGenreRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->genreRepository = $genreRepository;
        $this->movieGenreRepository = $movieGenreRepository;
    }

    public function index(string $slug): Collection
    {
        $genre = $this->genreRepository->getBySlug($slug);
        $movieIds = $this->movieGenreRepository->getMovies($genre->id);
        $movies = $this->movieRepository->moviesLatestByIds($movieIds);

        return $movies;
    }
}
