<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use function App\Helpers\convert_to_slug;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll(?string $keyword = null)
    {

        return $keyword ? $this->categoryRepository->getSearch($keyword) : $this->categoryRepository->getAll();
    }

    public function getPaginate(?string $keyword = null): LengthAwarePaginator
    {

        return $keyword ? $this->categoryRepository->getSearch($keyword) : $this->categoryRepository->getPaginate();
    }

    public function createCategory(array $data): Category
    {

        return $this->categoryRepository->create([
            'title' => $data['title'],
            'slug' => convert_to_slug($data['slug']),
            'description' => $data['description'],
            'status' => $data['status'],
            'created_at' => Carbon::now(),
        ]);
    }

    public function getCategoryById(Category $category): Category
    {

        return $category;
    }

    public function updateCategory(Category $category, array $data): Category
    {

        return $this->categoryRepository->update($category, [
            'title' => $data['title'],
            'slug' => convert_to_slug($data['slug']),
            'description' => $data['description'],
            'status' => $data['status'],
            'updated_at' => Carbon::now(),
        ]);
    }

    public function deleteCategory(Category $category): bool
    {

        return $this->categoryRepository->delete($category);
    }

    public function destroyMultiple(array $ids): bool
    {

        return $this->categoryRepository->destroy($ids);
    }

    public function pluckTitle(): Collection
    {

        return $this->categoryRepository->pluckTitle();
    }
}
