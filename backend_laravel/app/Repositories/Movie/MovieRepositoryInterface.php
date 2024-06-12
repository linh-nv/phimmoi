<?php
namespace App\Repositories\Movie;

use Illuminate\Database\Eloquent\Collection;

interface MovieRepositoryInterface
{
    public function search(string $keyword): Collection;

}
