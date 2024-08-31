<?php

namespace App\Console\Commands;

use App\Enums\MovieQuality;
use App\Enums\MovieStatus;
use App\Enums\MovieType;
use App\Models\Category;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Genre;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Util\CategoryDataTemplate;
use App\Util\Constants;
use Carbon\Carbon;
use Exception;

class CrawlMovies extends Command
{
    protected $signature = 'crawl:movies';
    protected $description = 'Crawl movies data from external API and store into database';

    public function handle(): void
    {
        $startTime = microtime(true);
        $this->info('Starting movie data crawl...');

        $this->crawlAllMovies();

        $endTime = microtime(true);
        $executionTime = $this->formatExecutionTime($endTime - $startTime);
        $this->info("Crawling completed.");
        $this->info("Total execution time: {$executionTime}.");
    }

    private function crawlAllMovies(): void
    {
        $apiUrl = Constants::API_CRAWL_MOVIES;

        // Get initial page to determine total pages and items
        $initialResponse = $this->fetchDataWithRetries($apiUrl . 1);
        $totalPages = $initialResponse['pagination']['totalPages'];
        $totalItems = $initialResponse['pagination']['totalItems'];

        CategoryDataTemplate::setCategoryTemplate();
        $processedCount = 0;
        $moviesData = [];
        $episodesData = [];

        // Crawl data from each page
        for ($page = 1; $page <= $totalPages; $page++) {
            $pageData = $this->fetchDataWithRetries($apiUrl . $page);
            if (!$pageData || empty($pageData['items'])) {
                continue;
            }

            $this->processMovies($pageData['items'], $moviesData, $episodesData, $processedCount, $totalItems);

            // Calculate and display progress percentage
            $progress = round(($processedCount / $totalItems) * 100, 2);
            $this->info("Progress: {$progress}% ({$processedCount} / {$totalItems} movies processed)");
        }

        // Save the crawled data to the database
        $this->saveMovies($moviesData);
        $this->saveEpisodes($episodesData);
    }

    private function fetchDataWithRetries(string $url, int $retries = 10): ?array
    {
        while ($retries > 0) {
            try {
                $response = Http::get($url);
                if ($response->successful()) {

                    return $response->json();
                }

                $this->error("Failed to fetch data from {$url}. Error: " . $response->body());
            } catch (Exception $e) {
                $this->error("Connection error: " . $e->getMessage());
            }

            $retries--;
            if ($retries > 0) {
                $this->info("Retrying... ($retries attempts left)");
                sleep(rand(1, 5));
            }
        }

        $this->error("Failed to fetch data after multiple attempts. Skipping URL: {$url}.");

        return null;
    }

    private function processMovies(array $movies, array &$moviesData, array &$episodesData, int &$processedCount, int $totalItems): void
    {
        foreach ($movies as $movieData) {
            $details = $this->getMovieDetails($movieData['slug']);
            if (!$details || strtolower($details['movie']['episode_current']) === 'trailer') {

                continue;
            }

            $movieRecord = $this->prepareMovieRecord($details['movie']);
            $moviesData[] = $movieRecord;

            $episodeRecords = $this->prepareEpisodeRecords($details['episodes'][0]['server_data'], $movieRecord['slug']);
            $episodesData = array_merge($episodesData, $episodeRecords);

            $processedCount++;
            $progress = round(($processedCount / $totalItems) * 100, 2);
            $this->info("Progress: {$progress}% ({$processedCount} / {$totalItems} movies processed)");
        }
    }

    private function getMovieDetails(string $slug): ?array
    {
        $apiUrl = Constants::API_CRAWL_DETAILS_MOVIE . $slug;

        return $this->fetchDataWithRetries($apiUrl);
    }

    private function prepareMovieRecord(array $movieDetails): array
    {
        $genreIds = $this->getGenreIds($movieDetails['category']);
        $country = $this->getOrCreateCountry($movieDetails['country'][0]);
        $category = $this->determineCategory($movieDetails);

        return [
            'slug' => $movieDetails['slug'],
            'name' => $movieDetails['name'],
            'origin_name' => $movieDetails['origin_name'],
            'content' => $movieDetails['content'],
            'type' => MovieType::valueFromLable(strtolower($movieDetails['type'])),
            'status' => MovieStatus::valueFromLable(strtolower($movieDetails['status'])),
            'thumb_url' => $movieDetails['thumb_url'],
            'poster_url' => $movieDetails['poster_url'],
            'is_copyright' => $movieDetails['is_copyright'],
            'sub_docquyen' => $movieDetails['sub_docquyen'],
            'chieurap' => $movieDetails['chieurap'],
            'trailer_url' => $movieDetails['trailer_url'],
            'time' => $movieDetails['time'],
            'episode_current' => $movieDetails['episode_current'],
            'episode_total' => $movieDetails['episode_total'],
            'quality' => MovieQuality::valueFromLable(strtolower($movieDetails['quality'])),
            'lang' => $movieDetails['lang'],
            'notify' => $movieDetails['notify'],
            'showtimes' => $movieDetails['showtimes'],
            'year' => $movieDetails['year'],
            'view' => $movieDetails['view'],
            'actor' => implode(', ', $movieDetails['actor']),
            'director' => implode(', ', $movieDetails['director']),
            'category_id' => $category->id,
            'country_id' => $country->id,
            'genres' => $genreIds,
            'created_at' => Carbon::parse($movieDetails['created']['time']),
            'updated_at' => Carbon::parse($movieDetails['modified']['time']),
        ];
    }

    private function getGenreIds(array $genres): array
    {
        $genreIds = [];
        foreach ($genres as $genreData) {
            if ($genreData['slug']) {
                $genre = Genre::firstOrCreate(['slug' => $genreData['slug']], ['title' => $genreData['name']]);
                $genreIds[] = $genre->id;
            }
        }

        return $genreIds;
    }

    private function getOrCreateCountry(array $countryData): Country
    {

        return Country::firstOrCreate(['slug' => $countryData['slug']], ['title' => $countryData['name']]);
    }

    private function determineCategory(array $movieDetails): ?Category
    {
        if ($movieDetails['episode_current'] == 'Full') {

            return Category::where('slug', CategoryDataTemplate::PHIMLE_SLUG)->first();
        } elseif ($movieDetails['chieurap']) {

            return Category::where('slug', CategoryDataTemplate::PHIMCHIEURAP_SLUG)->first();
        } else {

            return Category::where('slug', CategoryDataTemplate::PHIMBO_SLUG)->first();
        }
    }

    private function prepareEpisodeRecords(array $episodes, string $movieSlug): array
    {
        $episodeRecords = [];
        foreach ($episodes as $episode) {
            $episodeRecords[] = [
                'movie_slug' => $movieSlug,
                'name' => $episode['name'],
                'slug' => $episode['slug'],
                'link_embed' => $episode['link_embed'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $episodeRecords;
    }

    private function saveMovies(array $moviesData): void
    {
        $chunkSize = Constants::CHUNK_SIZE;
        foreach (array_chunk($moviesData, $chunkSize) as $index => $chunk) {
            $this->info('Saving movie chunk ' . ($index + 1));
            $chunkWithoutGenres = array_map(fn($movie) => array_diff_key($movie, ['genres' => '']), $chunk);
            Movie::upsert($chunkWithoutGenres, ['slug'], [
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
            ]);

            $this->syncMovieGenres($chunk);
        }
    }

    private function syncMovieGenres(array $moviesData): void
    {
        foreach ($moviesData as $movieData) {
            $movie = Movie::where('slug', $movieData['slug'])->first();
            if ($movie) {
                $movie->genres()->sync($movieData['genres']);
            }
        }
    }

    private function saveEpisodes(array $episodesData): void
    {
        $chunkSize = Constants::CHUNK_SIZE;
        foreach (array_chunk($episodesData, $chunkSize) as $index => $chunk) {
            $this->info('Saving episode chunk ' . ($index + 1));

            Episode::upsert(
                $chunk,
                ['movie_slug', 'slug'],
                ['name', 'link_embed', 'updated_at']
            );
        }
    }

    private function formatExecutionTime(float $seconds): string
    {
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        $milliseconds = round(($seconds - floor($seconds)) * 1000);

        return sprintf('%02d minutes %02d seconds %03d milliseconds', $minutes, $seconds, $milliseconds);
    }
}
