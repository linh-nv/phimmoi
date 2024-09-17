<?php

namespace App\Repositories\Movie;

use App\Models\Movie;
use App\Repositories\BaseRepository;
use App\Util\Constants;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Builder;

class MovieRepository extends BaseRepository implements MovieRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return Movie::class;
    }

    public function findBySlug($slug): Movie
    {

        return $this->_model->where('slug', $slug)->firstOrFail();
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
    public function clientSearch(string $keyword): ?Collection
    {
        $searchFields = ['name', 'slug', 'origin_name', 'year', 'actor', 'director'];

        return $this->_model
            ->select(['name', 'slug', 'origin_name', 'poster_url', 'thumb_url'])
            ->whereAny($searchFields, 'LIKE', "%$keyword%")
            ->latest('updated_at')
            ->take(Constants::PER_PAGE)
            ->get();
    }

    public function getMoviesByCategory(int $categoryId): ?Collection
    {

        return $this->movieSummaryInformation('category_id', $categoryId);
    }

    public function getMoviesByCountry(int $countryId): ?Collection
    {

        return $this->movieSummaryInformation('country_id', $countryId);
    }

    public function movieSummaryInformation(string $field = null, int $value = null, int $num = Constants::SIDER_ITEMS): ?Collection
    {
        return $this->_model
            ->select(['name', 'slug', 'origin_name', 'year', 'poster_url', 'thumb_url'])
            ->where($field, $value)
            ->latest('updated_at')
            ->take($num)
            ->get();
    }

    public function moviesLatestByIds(SupportCollection $movieIds, int $page = Constants::CLIENT_PAGE): ?Collection
    {
        return $this->_model
            ->select(['name', 'slug', 'origin_name', 'year', 'poster_url', 'thumb_url'])
            ->whereIn('id', $movieIds)
            ->latest('updated_at')
            ->take($page)
            ->get();
    }

    public function moviesByIds(SupportCollection $movieIds, int $page = Constants::CLIENT_PAGE): ?Collection
    {
        if ($movieIds->isEmpty()) {

            return null;
        }

        $idsOrdered = $movieIds->implode(',');

        return $this->_model
            ->select(['name', 'slug', 'origin_name', 'year', 'view', 'poster_url', 'thumb_url'])
            ->whereIn('id', $movieIds)
            ->orderByRaw("FIELD(id, $idsOrdered)")
            ->take($page)
            ->get();
    }

    public function filterMovies(SupportCollection $filters, int $page = Constants::CLIENT_PAGE): LengthAwarePaginator
    {
        $query = $this->_model->query();

        if (!empty($filters['year'])) {
            $query->where('year', $filters['year'])->latest('updated_at');
        }

        if (!empty($filters['view'])) {
            $query->latest('view');
        }

        if (!empty($filters['update'])) {
            $query->latest('updated_at');
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id'])->latest('updated_at');
        }

        if (!empty($filters['genre_id'])) {
            $query->whereHas('genres', function (Builder $query) use ($filters) {
                $query->where('genres.id', $filters['genre_id'])->latest('movies.updated_at');
            });
        }

        if (!empty($filters['country_id'])) {
            $query->where('country_id', $filters['country_id'])->latest('updated_at');
        }

        if (!empty($filters['keyword'])) {
            $query->where(function ($query) use ($filters) {
                $query->where('name', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('slug', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('origin_name', 'like', '%' . $filters['keyword'] . '%')
                    ->latest('updated_at');
            });
        }

        return $query->paginate($page);
    }
}
