<?php

namespace App\Repositories\MovieView;

use App\Repositories\BaseRepository;
use App\Util\Constants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MovieViewRepository extends BaseRepository implements MovieViewRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\MovieView::class;
    }

    public function getMoviesDay(): ?Collection
    {
        $startOfYesterday = Carbon::yesterday()->startOfDay();
        $endOfToday = Carbon::today()->endOfDay();

        return $this->getMoviesTop($startOfYesterday, $endOfToday);
    }

    public function getMoviesWeek(): ?Collection
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        return $this->getMoviesTop($startOfWeek, $endOfWeek);
    }

    public function getMoviesMonth(): ?Collection
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return $this->getMoviesTop($startOfMonth, $endOfMonth);
    }

    public function getMoviesYear(): ?Collection
    {
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        return $this->getMoviesTop($startOfYear, $endOfYear);
    }

    public function getMoviesTop(Carbon $start, Carbon $end): ?Collection
    {

        return $this->_model
            ->select('movie_id')
            ->whereBetween('viewed_at', [$start, $end])
            ->groupBy('movie_id')
            ->orderByRaw('COUNT(*) DESC')
            ->take(Constants::PER_PAGE)
            ->pluck('movie_id');
    }

    public function createView(int $movieId): Model
    {

        return $this->_model->create([
            'movie_id' => $movieId,
            'viewed_at' => now()
        ]);
    }
}
