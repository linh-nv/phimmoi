<?php

namespace App\Pipeline\CrawlMovies\Tasks;

use App\Util\Constains;
use App\Pipeline\CrawlMovies\FetchMovies;

class GetMovieDetails
{
    public function execute(string $slug): ?array
    {
        $apiUrl = Constains::API_CRAWL_DETAILS_MOVIE . $slug;
        return FetchMovies::fetchDataWithRetries($apiUrl);
    }
}
