<?php
namespace App\Repositories\Genre;

use App\Repositories\BaseRepository;
use App\Util\Constains;
use Illuminate\Pagination\LengthAwarePaginator;

class GenreRepository extends BaseRepository implements GenreRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {
        
        return \App\Models\Genre::class;
    }

    public function getSearch(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['title', 'slug', 'description', 'status'];

        return $this->search($searchFields, $keyword);
    }
}
