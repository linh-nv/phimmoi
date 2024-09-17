<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CategoryService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    use ResponseHandler;

    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $slug = $request->slug;
            $moviesCategory = $this->categoryService->index($slug);

            return $this->responseSuccess(Response::HTTP_OK, $moviesCategory);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
