<?php

namespace App\Pipeline\CrawlMovies;

use App\Models\Movie;
use App\Repositories\Movie\MovieRepository;
use Closure;

class SaveMovies
{
    protected $movieRepository;

    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    public function handle($data, Closure $next)
    {
        $chunkSize = 1000;
        foreach (array_chunk($data['moviesData'], $chunkSize) as $index => $chunk) {
            $chunkWithoutGenres = array_map(fn($movie) => array_diff_key($movie, ['genres' => '']), $chunk);
            $this->movieRepository->upsert(
                $chunkWithoutGenres,
                ['slug'],
                [
                    'name',
                    'origin_name',
                    'content',
                    'type',
                    'status',
                    'quality',
                    'thumb_url',
                    'poster_url',
                    'is_copyright',
                    'sub_docquyen',
                    'chieurap',
                    'trailer_url',
                    'time',
                    'episode_current',
                    'episode_total',
                    'lang',
                    'notify',
                    'showtimes',
                    'year',
                    'view',
                    'actor',
                    'director',
                    'created_at',
                    'updated_at'
                ]
            );

            $this->syncMovieGenres($chunk);
        }

        return $next($data);
    }

    private function syncMovieGenres(array $moviesData): void
    {
        foreach ($moviesData as $movieData) {
            $movie = $this->movieRepository->findBySlug($movieData['slug']);
            if ($movie) {
                $movie->genres()->sync($movieData['genres']);
            }
        }
    }
}
