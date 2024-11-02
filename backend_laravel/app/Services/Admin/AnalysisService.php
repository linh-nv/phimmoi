<?php

namespace App\Services\Admin;

use App\Repositories\Analysis\AnalysisRepository;
use Illuminate\Support\Collection;

class AnalysisService
{
    protected AnalysisRepository $analysisRepository;

    public function __construct(AnalysisRepository $analysisRepository)
    {
        $this->analysisRepository = $analysisRepository;
    }

    public function getOverview(): Collection
    {
        $newUsers = $this->analysisRepository->getNewUsersInMonth();
        $totalViews = $this->analysisRepository->getTotalViewsInMonth();
        $newMovies = $this->analysisRepository->getNewMoviesInMonth();
        $viewsByGenre = $this->analysisRepository->getViewsByGenreInMonth();

        return collect([
            'new_users' => $newUsers,
            'total_views' => $totalViews,
            'new_movies' => $newMovies,
            'views_by_genre' => $viewsByGenre,
        ]);
    }
}
