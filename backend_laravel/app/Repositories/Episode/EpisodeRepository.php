<?php

namespace App\Repositories\Episode;

use App\Repositories\BaseRepository;
use App\Util\Constains;
use Illuminate\Pagination\LengthAwarePaginator;

class EpisodeRepository extends BaseRepository implements EpisodeRepositoryInterface
{
    /**
     * get model
     * @return string
     */
    public function getModel(): string
    {

        return \App\Models\Episode::class;
    }

    public function getSearch(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['name', 'slug', 'link_embed'];

        return $this->search($searchFields, $keyword);
    }
}
