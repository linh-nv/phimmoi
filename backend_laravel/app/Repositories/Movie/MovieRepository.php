<?php

namespace App\Repositories\Movie;

use App\Models\Movie;
use App\Repositories\BaseRepository;
use App\Util\Constants;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

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

    /*
    * =======================================
    * Client repository
    */
    public function getMoviesByCategory(int $categoryId): ?Collection
    {

        return $this->movieSummaryInformation('category_id', $categoryId);
    }

    public function getMoviesByCountry(int $countryId): ?Collection
    {

        return $this->movieSummaryInformation('country_id', $countryId);
    }

    public function movieSummaryInformation(string $field, int $value): ?Collection
    {
        return $this->_model
            ->select(['name', 'slug', 'origin_name', 'poster_url', 'thumb_url'])
            ->where($field, $value)
            ->latest('updated_at')
            ->take(Constants::CLIENT_PAGE)
            ->get();
    }

    public function moviesLatestByIds(SupportCollection $movieIds, int $page = Constants::CLIENT_PAGE): ?Collection
    {
        return $this->_model
            ->select(['name', 'slug', 'origin_name', 'poster_url', 'thumb_url'])
            ->whereIn('id', $movieIds)
            ->latest('updated_at')
            ->take($page)
            ->get();
    }

    public function moviesByIds(SupportCollection $movieIds, int $page = Constants::CLIENT_PAGE): ?Collection
    {
        $idsOrdered = $movieIds->implode(',');
    
        return $this->_model
            ->select(['name', 'slug', 'origin_name', 'poster_url', 'thumb_url'])
            ->whereIn('id', $movieIds)
            ->orderByRaw("FIELD(id, $idsOrdered)")
            ->take($page)
            ->get();
    }
}
