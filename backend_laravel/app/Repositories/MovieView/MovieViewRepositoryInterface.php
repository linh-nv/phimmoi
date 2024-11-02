<?php
namespace App\Repositories\MovieView;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface MovieViewRepositoryInterface
{
    public function getMoviesDay(): ?Collection;
    public function getMoviesWeek(): ?Collection;
    public function getMoviesMonth(): ?Collection;
    public function getMoviesYear(): ?Collection;
    public function getMoviesTop(Carbon $start, Carbon $end): ?Collection;
}
