<?php

namespace App\Pipeline\CrawlMovies\Tasks;

use App\Util\Constants;
use App\Pipeline\CrawlMovies\FetchMovies;

class GetMovieDetails
{
    public function execute(string $slug): ?array
    {
        $apiUrl = Constants::API_CRAWL_DETAILS_MOVIE . $slug;
        return FetchMovies::fetchDataWithRetries($apiUrl);
    }
}
