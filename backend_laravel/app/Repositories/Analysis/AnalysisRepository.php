<?php

namespace App\Repositories\Analysis;

use App\Models\User;
use App\Models\Movie;
use App\Models\MovieView;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalysisRepository implements AnalysisRepositoryInterface
{
    public function getNewUsersInMonth(): int
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return User::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
    }

    public function getTotalViewsInMonth(): int
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return MovieView::whereBetween('viewed_at', [$startOfMonth, $endOfMonth])->count();
    }

    public function getNewMoviesInMonth(): int
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return Movie::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
    }

    public function getViewsByGenreInMonth(): array
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return DB::table('movie_view')
            ->join('movies', 'movie_view.movie_id', '=', 'movies.id')
            ->join('movie_genre', 'movies.id', '=', 'movie_genre.movie_id')
            ->join('genres', 'movie_genre.genre_id', '=', 'genres.id')
            ->select('genres.title', DB::raw('COUNT(movie_view.id) as total_views'))
            ->whereBetween('movie_view.viewed_at', [$startOfMonth, $endOfMonth])
            ->groupBy('genres.title')
            ->orderBy('total_views', 'desc')
            ->get()
            ->toArray();
    }
}
