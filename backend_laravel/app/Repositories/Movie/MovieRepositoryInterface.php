<?php
namespace App\Repositories\Movie;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface MovieRepositoryInterface
{
    public function loadRelationship(Movie $movie): Movie;
    public function getRelationship(): LengthAwarePaginator;
    public function getSearch(string $keyword): LengthAwarePaginator;
    public function attachGenres(Movie $movie, array $genreIds): void;
    public function syncGenres(Movie $movie, array $genreIds): void;
}
