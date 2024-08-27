<?php

namespace App\Pipeline\CrawlMovies\Tasks;

use App\Repositories\Genre\GenreRepository;

class GetGenreIds
{
    protected $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function execute(array $genres): array
    {
        $genreIds = [];
        foreach ($genres as $genreData) {
            if ($genreData['slug']) {
                $genre = $this->genreRepository->firstOrCreate(['slug' => $genreData['slug']], ['title' => $genreData['name']]);
                $genreIds[] = $genre->id;
            }
        }

        return $genreIds;
    }
}
