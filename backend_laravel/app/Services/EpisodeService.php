<?php

namespace App\Services;

use App\Models\Episode;
use App\Repositories\Episode\EpisodeRepository;
use Carbon\Carbon;

use function App\Helpers\convert_to_slug;

class EpisodeService
{
    protected EpisodeRepository $episodeRepository;

    public function __construct(EpisodeRepository $episodeRepository)
    {
        $this->episodeRepository = $episodeRepository;
    }

    public function getAll(?string $keyword = null)
    {

        return $keyword ? $this->episodeRepository->getSearch($keyword) : $this->episodeRepository->getAll();
    }

    public function getPaginate(?string $keyword = null)
    {

        return $keyword ? $this->episodeRepository->getSearch($keyword) : $this->episodeRepository->getPaginate();
    }

    public function createEpisode(array $data): Episode
    {

        return $this->episodeRepository->create([
            'movie_id' => $data['movie_id'],
            'name' => $data['name'],
            'slug' => convert_to_slug($data['slug']),
            'link_embed' => $data['link_embed'],
            'created_at' => Carbon::now(),
        ]);
    }

    public function getEpisodeById(Episode $episode): Episode
    {

        return $this->episodeRepository->find($episode);
    }

    public function updateEpisode(Episode $episode, array $data): Episode
    {

        return $this->episodeRepository->update($episode, [
            'movie_id' => $data['movie_id'],
            'name' => $data['name'],
            'slug' => convert_to_slug($data['slug']),
            'link_embed' => $data['link_embed'],
            'updated_at' => Carbon::now(),
        ]);
    }

    public function deleteEpisode(Episode $episode): bool
    {

        return $this->episodeRepository->delete($episode);
    }

    public function destroyMultiple(array $ids): bool
    {

        return $this->episodeRepository->destroy($ids);
    }
}
