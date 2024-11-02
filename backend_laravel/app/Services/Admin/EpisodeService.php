<?php

namespace App\Services\Admin;

use App\Models\Episode;
use App\Repositories\Episode\EpisodeRepository;
use App\Repositories\Movie\MovieRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use function App\Helpers\convert_to_slug;

class EpisodeService
{
    protected EpisodeRepository $episodeRepository;
    protected MovieRepository $movieRepository;

    public function __construct(EpisodeRepository $episodeRepository, MovieRepository $movieRepository)
    {
        $this->episodeRepository = $episodeRepository;
        $this->movieRepository = $movieRepository;
    }

    public function getEpisodesByMovie($movieSlug): LengthAwarePaginator
    {

        return $this->episodeRepository->getEpisodesByMovie($movieSlug);
    }

    public function getAll(?string $keyword = null)
    {

        return $keyword ? $this->episodeRepository->getSearch($keyword) : $this->episodeRepository->getAll();
    }

    public function getPaginate(?string $keyword = null): LengthAwarePaginator
    {

        return $keyword ? $this->episodeRepository->getSearch($keyword) : $this->episodeRepository->getPaginate();
    }

    public function createEpisode(array $data): Episode
    {

        return $this->episodeRepository->create([
            'movie_slug' => $data['movie_slug'],
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
            'movie_slug' => $data['movie_slug'],
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
