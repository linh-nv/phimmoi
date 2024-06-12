<?php

namespace App\Services;

use App\Http\Resources\MovieResource;
use App\Models\Movie;
use App\Repositories\Movie\MovieRepository;
use Carbon\Carbon;

use function App\Helpers\convert_to_slug;

class MovieService
{
    protected MovieRepository $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function getAll(?string $keyword = null)
    {
        $movies = $keyword ? $this->movieRepository->search($keyword) : $this->movieRepository->getAll();
        return MovieResource::collection($movies);
    }

    public function getPaginate(?string $keyword = null)
    {
        $movies = $keyword ? $this->movieRepository->search($keyword) : $this->movieRepository->getPaginate();
        return MovieResource::collection($movies);
    }

    public function createMovie(array $data): MovieResource
    {
        $movie = $this->movieRepository->create([
            'name' => $data['name'],
            'slug' => convert_to_slug($data['slug']),
            'origin_name' => $data['origin_name'],
            'content' => $data['content'],
            'type' => $data['type'],
            'status' => $data['status'],
            'poster_url' => $data['poster_url'],
            'thumb_url' => $data['thumb_url'],
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
            'created_at' => Carbon::now(),
        ]);

        return new MovieResource($movie);
    }

    public function getMovieById(Movie $movie): MovieResource
    {
        return new MovieResource($this->movieRepository->find($movie));
    }

    public function updateMovie(Movie $movie, array $data): MovieResource
    {
        $updatedMovie = $this->movieRepository->update($movie, [
            'name' => $data['name'],
            'slug' => convert_to_slug($data['slug']),
            'origin_name' => $data['origin_name'],
            'content' => $data['content'],
            'type' => $data['type'],
            'status' => $data['status'],
            'poster_url' => $data['poster_url'],
            'thumb_url' => $data['thumb_url'],
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
            'updated_at' => Carbon::now(),
        ]);

        return new MovieResource($updatedMovie);
    }

    public function deleteMovie(Movie $movie): bool
    {
        return $this->movieRepository->delete($movie);
    }

    public function destroyMultiple(array $ids): bool
    {
        return $this->movieRepository->destroy($ids);
    }
}
