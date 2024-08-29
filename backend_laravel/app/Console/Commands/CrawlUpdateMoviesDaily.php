<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use App\Pipeline\CrawlMovies\FetchMoviesDaily;
use App\Pipeline\CrawlMovies\ProcessMovies;
use App\Pipeline\CrawlMovies\SaveMovies;
use App\Pipeline\CrawlMovies\SaveEpisodes;
use App\Util\CategoryDataTemplate;

class CrawlUpdateMoviesDaily extends Command
{
    protected $signature = 'crawl:movies-daily';
    protected $description = 'Crawl a limited number of movies pages from external API and store into database';

    public function handle(): void
    {
        $startTime = microtime(true);
        $this->info('Starting update movie data crawl...');
        CategoryDataTemplate::setCategoryTemplate();

        $data = app(Pipeline::class)
            ->send([])
            ->through([
                FetchMoviesDaily::class,
                ProcessMovies::class,
                SaveMovies::class,
                SaveEpisodes::class,
            ])
            ->thenReturn();

        $endTime = microtime(true);
        $executionTime = $this->formatExecutionTime($endTime - $startTime);
        $this->info("Limited crawling completed.");
        $this->info("Total execution time: {$executionTime}.");
    }

    private function formatExecutionTime(float $seconds): string
    {
        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;
        $milliseconds = round(($seconds - floor($seconds)) * 1000);
        return sprintf('%02d minutes %02d seconds %03d milliseconds', $minutes, $seconds, $milliseconds);
    }
}