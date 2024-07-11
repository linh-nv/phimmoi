<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Messages\ResponseMessages;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use ResponseHandler;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $keyword = $request->query('keyword');

        try {
            $categories = $this->categoryService->getPaginate($keyword);

            return $this->responseSuccess(Response::HTTP_OK, $categories);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request): JsonResponse
    {
        try {
            $category = $this->categoryService->createCategory($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $category);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('CREATE_ERROR'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category): JsonResponse
    {
        try {
            $category = $this->categoryService->getCategoryById($category);

            return $this->responseSuccess(Response::HTTP_OK, $category);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        try {
            $category = $this->categoryService->updateCategory($category, $request->all());

            return $this->responseSuccess(Response::HTTP_OK, $category);
        } catch (\Exception $e) {
            throw $e;
            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('UPDATE_ERROR'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        try {
            $this->categoryService->deleteCategory($category);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('DELETE_ERROR'));
        }
    }

    /**
     * Remove the multi resource from storage.
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $ids = $request->input('ids');

        try {
            $this->categoryService->destroyMultiple($ids);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('DELETE_ERROR'));
        }
    }
}
