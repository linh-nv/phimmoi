<?php

namespace App\Services\Admin;

use App\Singletons\ResourceSingleton;
use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieResourceCollection;
use App\Models\Movie;
use App\Repositories\Movie\MovieRepository;
use Carbon\Carbon;
use function App\Helpers\convert_to_slug;
use function App\Helpers\deleteFile;
use function App\Helpers\uploadFile;

class MovieService
{
    protected MovieRepository $movieRepository;
    protected $resourceSingleton;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->resourceSingleton = ResourceSingleton::getInstance();
    }

    public function getAll(?string $keyword = null): MovieResource
    {
        $movies = $keyword ? $this->movieRepository->getSearch($keyword) : $this->movieRepository->getAll();

        return $this->resourceSingleton->getResource(MovieResource::class, $movies);
    }

    public function getPaginate(?string $keyword = null): MovieResourceCollection
    {
        $movies = $keyword ? $this->movieRepository->getSearch($keyword) : $this->movieRepository->getRelationship();

        return $this->resourceSingleton->getResource(MovieResourceCollection::class, $movies);
    }

    public function createMovie(array $data): MovieResource
    {
        $slug = convert_to_slug($data['slug']);

        // Upload poster
        if (isset($data['poster'])) {
            $posterUrl = uploadFile($data['poster'], $slug, 'poster');
        }
        // Upload thumbnail
        if (isset($data['thumb'])) {
            $thumbUrl = uploadFile($data['thumb'], $slug, 'thumb');
        }

        $movie = $this->movieRepository->create([
            'name' => $data['name'],
            'slug' => $slug,
            'origin_name' => $data['origin_name'],
            'content' => $data['content'],
            'type' => $data['type'],
            'status' => $data['status'],
            'poster_url' => $posterUrl ?? null,
            'thumb_url' => $thumbUrl ?? null,
            'is_copyright' => $data['is_copyright'],
            'sub_docquyen' => $data['sub_docquyen'],
            'chieurap' => $data['chieurap'],
            'trailer_url' => $data['trailer_url'],
            'time' => $data['time'],
            'episode_current' => $data['episode_current'],
            'episode_total' => $data['episode_total'],
            'quality' => $data['quality'],
            'lang' => $data['lang'],
            'notify' => $data['notify'],
            'showtimes' => $data['showtimes'],
            'year' => $data['year'],
            'actor' => implode(',', $data['actor']),
            'director' => implode(',', $data['director']),
            'country_id' => $data['country_id'],
            'category_id' => $data['category_id'],
            'created_at' => Carbon::now(),
        ]);

        if (isset($data['genre_ids'])) {
            $this->movieRepository->attachGenres($movie, $data['genre_ids']);
        }

        $this->resourceSingleton->reset(MovieResource::class);

        return $this->resourceSingleton->getResource(MovieResource::class, $movie);
    }

    public function getMovieById(Movie $movie): MovieResource
    {
        $movie = $this->movieRepository->find($movie);
        $this->movieRepository->loadRelationship($movie);

        return $this->resourceSingleton->getResource(MovieResource::class, $movie);
    }

    public function updateMovie($slug, array $data): MovieResource
    {
        $movie = $this->movieRepository->where('slug', $slug);
        $slug = convert_to_slug($data['slug']);

        // Upload poster
        if (isset($data['poster'])) {
            $posterUrl = uploadFile($data['poster'], $slug, 'poster');
        }
        // Upload thumbnail
        if (isset($data['thumb'])) {
            $thumbUrl = uploadFile($data['thumb'], $slug, 'thumb');
        }

        $updatedMovie = $this->movieRepository->update($movie, [
            'name' => $data['name'],
            'slug' => convert_to_slug($data['slug']),
            'origin_name' => $data['origin_name'],
            'content' => $data['content'],
            'type' => $data['type'],
            'status' => $data['status'],
            'poster_url' => $posterUrl ?? $movie->poster_url,
            'thumb_url' => $thumbUrl ?? $movie->thumb_url,
            'is_copyright' => $data['is_copyright'],
            'sub_docquyen' => $data['sub_docquyen'],
            'chieurap' => $data['chieurap'],
            'trailer_url' => $data['trailer_url'],
            'time' => $data['time'],
            'episode_current' => $data['episode_current'],
            'episode_total' => $data['episode_total'],
            'quality' => $data['quality'],
            'lang' => $data['lang'],
            'notify' => $data['notify'],
            'showtimes' => $data['showtimes'],
            'year' => $data['year'],
            'actor' => implode(',', $data['actor']),
            'director' => implode(',', $data['director']),
            'country_id' => $data['country_id'],
            'category_id' => $data['category_id'],
            'updated_at' => Carbon::now(),
        ]);

        // Sync genres
        if (isset($data['genre_ids'])) {
            $this->movieRepository->syncGenres($movie, $data['genre_ids']);
        }

        $this->resourceSingleton->reset(MovieResource::class);

        return $this->resourceSingleton->getResource(MovieResource::class, $updatedMovie);
    }

    public function deleteMovie(Movie $movie): bool
    {
        if ($movie->poster_url) {
            deleteFile($movie->poster_url);
        }
        if ($movie->thumb_url) {
            deleteFile($movie->thumb_url);
        }

        return $this->movieRepository->delete($movie);
    }

    public function destroyMultiple(array $ids): bool
    {
        $movies = $this->movieRepository->findByIds($ids);
        foreach ($movies as $movie) {
            if ($movie->poster_url) {
                deleteFile($movie->poster_url);
            }

            if ($movie->thumb_url) {
                deleteFile($movie->thumb_url);
            }
        }

        return $this->movieRepository->destroy($ids);
    }
}
