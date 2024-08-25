<?php

namespace App\Repositories\Episode;

use App\Repositories\BaseRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Util\Constains;

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

    public function getEpisodesByMovie(string $movie_id): LengthAwarePaginator
    {

        return $this->_model->where('movie_id', $movie_id)->paginate(Constains::PER_PAGE);
    }

    public function getSearch(string $keyword): LengthAwarePaginator
    {
        $searchFields = ['name', 'slug', 'link_embed'];

        return $this->search($searchFields, $keyword);
    }
}
