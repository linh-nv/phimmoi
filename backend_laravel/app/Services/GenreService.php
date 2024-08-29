<?php

namespace App\Services;

use App\Models\Genre;
use App\Repositories\Genre\GenreRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

use function App\Helpers\convert_to_slug;

class GenreService
{
    protected GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function getAll(?string $keyword = null)
    {

        return $keyword ? $this->genreRepository->getSearch($keyword) : $this->genreRepository->getAll();
    }

    public function getPaginate(?string $keyword = null): LengthAwarePaginator
    {

        return $keyword ? $this->genreRepository->getSearch($keyword) : $this->genreRepository->getPaginate();
    }

    public function createGenre(array $data): Genre
    {

        return $this->genreRepository->create([
            'title' => $data['title'],
            'slug' => convert_to_slug($data['slug']),
            'description' => $data['description'],
            'status' => $data['status'],
            'created_at' => Carbon::now(),
        ]);
    }

    public function getGenreById(Genre $genre): Genre
    {

        return $this->genreRepository->find($genre);
    }

    public function updateGenre(Genre $genre, array $data): Genre
    {

        return $this->genreRepository->update($genre, [
            'title' => $data['title'],
            'slug' => convert_to_slug($data['slug']),
            'description' => $data['description'],
            'status' => $data['status'],
            'updated_at' => Carbon::now(),
        ]);
    }

    public function deleteGenre(Genre $genre): bool
    {

        return $this->genreRepository->delete($genre);
    }

    public function destroyMultiple(array $ids): bool
    {

        return $this->genreRepository->destroy($ids);
    }

    public function pluckTitle(): Collection
    {

        return $this->genreRepository->pluckTitle();
    }
}
