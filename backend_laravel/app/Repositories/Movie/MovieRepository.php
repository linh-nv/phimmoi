<?php

namespace App\Repositories\Movie;

use App\Models\Movie;
use App\Repositories\BaseRepository;
use App\Util\Constants;
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

    public function findBySlug($slug): Movie
    {

        return $this->where('slug', $slug)->firstOrFail();
    }

    public function getRelationship(): LengthAwarePaginator
    {

        return $this->_model->with('category', 'genres', 'country', 'episodes')->orderBy('updated_at', 'DESC')->paginate(Constants::PER_PAGE);
    }

    public function loadRelationship(Movie $movie): Movie
    {

        return $movie->load(['category', 'genres', 'country', 'episodes']);
    }

    public function getSearch(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['name', 'slug', 'origin_name', 'year'];

        return $this->_model->whereAny($searchFields, 'LIKE', "%$keyword%")->latest('updated_at')->paginate(Constants::PER_PAGE);
    }

    public function getSearchActorAndDerector(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['actor', 'director'];

        $query = $this->_model->whereRaw(
            "MATCH(" . implode(',', $searchFields) . ") AGAINST(? WITH QUERY EXPANSION)",
            [$keyword]
        );

        return $query->latest('updated_at')->paginate(Constants::PER_PAGE);
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
