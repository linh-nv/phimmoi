<?php

namespace App\Pipeline\CrawlMovies;

use Illuminate\Support\Facades\Http;
use Closure;
use App\Util\Constains;
use Exception;

class FetchMovies
{
    public function handle($data, Closure $next)
    {
        $apiUrl = Constains::API_CRAWL_MOVIES;

        // Get initial page to determine total pages and items
        $initialResponse = $this->fetchDataWithRetries($apiUrl . 1);
        $totalPages = $initialResponse['pagination']['totalPages'];
        $data['totalPages'] = $totalPages;
        $data['movies'] = [];
        $data['moviesData'] = [];
        $data['episodesData'] = [];
        $processedCount = 1;
        // Crawl data from each page
        for ($page = 1; $page <= $totalPages; $page++) {
            $pageData = $this->fetchDataWithRetries($apiUrl . $page);
            if ($pageData && !empty($pageData['items'])) {
                $data['movies'][] = $pageData['items'];

                $progress = round(($processedCount / $totalPages) * 100, 2);
                echo "\nProgress: {$progress}% ({$processedCount} / {$totalPages} pages movie processed)\n";
                $processedCount++;
            }
        }

        return $next($data);
    }

    public static function fetchDataWithRetries(string $url, int $retries = 10): ?array
    {
        while ($retries > 0) {
            try {
                $response = Http::get($url);
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (Exception $e) {
                echo ('Error: '. $e->getMessage());
            }
            $retries--;
            sleep(rand(1, 5));
        }
        return null;
    }
}
