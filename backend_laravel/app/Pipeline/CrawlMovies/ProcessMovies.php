<?php

namespace App\Pipeline\CrawlMovies;

use App\Pipeline\CrawlMovies\Tasks\GetMovieDetails;
use App\Pipeline\CrawlMovies\Tasks\PrepareMovieRecord;
use App\Pipeline\CrawlMovies\Tasks\PrepareEpisodeRecords;
use Closure;

class ProcessMovies
{
    protected $getMovieDetails;
    protected $prepareMovieRecord;
    protected $prepareEpisodeRecords;

    public function __construct(GetMovieDetails $getMovieDetails, PrepareMovieRecord $prepareMovieRecord, PrepareEpisodeRecords $prepareEpisodeRecords)
    {
        $this->getMovieDetails = $getMovieDetails;
        $this->prepareMovieRecord = $prepareMovieRecord;
        $this->prepareEpisodeRecords = $prepareEpisodeRecords;
    }

    public function handle($data, Closure $next)
    {
        foreach ($data['movies'] as $movies) {
            foreach ($movies as $movieData) {
                $details = $this->getMovieDetails->execute($movieData['slug']);
                if ($details && strtolower($details['movie']['episode_current']) !== 'trailer') {
                    $data['moviesData'][] = $this->prepareMovieRecord->execute($details['movie']);
                    $data['episodesData'] = array_merge($data['episodesData'], $this->prepareEpisodeRecords->execute($details['episodes'][0]['server_data'], $movieData['slug']));
                }
            }
        }

        return $next($data);
    }
}
