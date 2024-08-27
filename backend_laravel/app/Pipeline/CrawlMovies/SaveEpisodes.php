<?php

namespace App\Pipeline\CrawlMovies;

use App\Repositories\Episode\EpisodeRepository;
use Closure;

class SaveEpisodes
{
    protected $episodeRepository;

    public function __construct(EpisodeRepository $episodeRepository)
    {
        $this->episodeRepository = $episodeRepository;
    }

    public function handle($data, Closure $next)
    {
        $chunkSize = 1000;
        foreach (array_chunk($data['episodesData'], $chunkSize) as $index => $chunk) {
            $this->episodeRepository->insert($chunk);
        }

        return $next($data);
    }
}
