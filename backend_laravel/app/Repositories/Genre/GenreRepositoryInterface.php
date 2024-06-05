<?php
namespace App\Repositories\Genre;

use Illuminate\Database\Eloquent\Collection;

interface GenreRepositoryInterface
{
    public function search(string $keyword): Collection;

}
