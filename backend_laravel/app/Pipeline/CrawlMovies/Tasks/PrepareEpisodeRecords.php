<?php

namespace App\Pipeline\CrawlMovies\Tasks;

class PrepareEpisodeRecords
{
    public function execute(array $episodes, string $movieSlug): array
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
}
