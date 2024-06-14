<?php
namespace App\Repositories\Movie;

use App\Models\Movie;
use App\Repositories\BaseRepository;
use App\Util\Constains;
use Illuminate\Pagination\LengthAwarePaginator;

class MovieRepository extends BaseRepository implements MovieRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {
        
        return \App\Models\Movie::class;
    }

    public function getRelationship(): LengthAwarePaginator
    {
        
        return $this->_model->with('category', 'genres', 'country')->orderBy('updated_at', 'DESC')->paginate(Constains::PER_PAGE);
    }

    public function loadRelationship(Movie $movie): Movie
    {

        return $movie->load(['category', 'genres', 'country']);
    }

    public function getSearch(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['name', 'slug', 'origin_name', 'content', 'type', 'year', 'actor', 'director'];

        return $this->_model->whereAny($searchFields, 'LIKE', "%$keyword%")
        ->orWhereHas('category', function ($query) use ($keyword) {
            $query->whereAny(['title', 'slug'], 'like', "%$keyword%");
        })
        ->orWhereHas('country', function ($query) use ($keyword) {
            $query->whereAny(['title', 'slug'], 'like', "%$keyword%");
        })
        ->orWhereHas('genres', function ($query) use ($keyword) {
            $query->whereAny(['title', 'slug'], 'like', "%$keyword%");
        })->paginate(Constains::PER_PAGE);
    }

    public function attachGenres(Movie $movie, array $genreIds): void
    {
        $movie->genres()->attach($genreIds);
    }

    public function syncGenres(Movie $movie, array $genreIds): void
    {
        $movie->genres()->sync($genreIds);
    }
}
