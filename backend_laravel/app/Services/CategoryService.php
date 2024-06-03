<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Carbon\Carbon;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getPaginate(?string $keyword = null)
    {
        return $keyword ? $this->categoryRepository->search($keyword) : $this->categoryRepository->getPaginate();
    }

    public function createCategory(array $data): Category
    {
        $categoryData = [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'status' => $data['status'],
            'created_at' => Carbon::now(),
        ];

        return $this->categoryRepository->create($categoryData);
    }

    public function getCategoryById(Category $category): Category
    {
        return $this->categoryRepository->find($category);
    }

    public function updateCategory(Category $category, array $data): Category
    {

        return $this->categoryRepository->update($category, [
            'title' => $data['title'],
            'slug' => $data['slug'],
            'description' => $data['description'],
            'status' => $data['status'],
        ]);
    }

    public function deleteCategory(Category $category): bool
    {

        return $this->categoryRepository->delete($category);
    }
}
