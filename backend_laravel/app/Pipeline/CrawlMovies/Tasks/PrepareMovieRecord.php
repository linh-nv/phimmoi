<?php

namespace App\Pipeline\CrawlMovies\Tasks;

use App\Enums\MovieQuality;
use App\Enums\MovieStatus;
use App\Enums\MovieType;
use Carbon\Carbon;

class PrepareMovieRecord
{
    protected $getGenreIds;
    protected $GetCountry;
    protected $determineCategory;

    public function __construct(GetGenreIds $getGenreIds, GetCountry $GetCountry, DetermineCategory $determineCategory)
    {
        $this->getGenreIds = $getGenreIds;
        $this->GetCountry = $GetCountry;
        $this->determineCategory = $determineCategory;
    }

    public function execute(array $movieDetails): array
    {
        $genreIds = $this->getGenreIds->execute($movieDetails['category']);
        $country = $this->GetCountry->execute($movieDetails['country'][0]);
        $category = $this->determineCategory->execute($movieDetails);

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
}
