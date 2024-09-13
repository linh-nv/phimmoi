<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\MovieService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieController extends Controller
{
    use ResponseHandler;

    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $slug = $request->slug;
            $movies = $this->movieService->index($slug);

            return $this->responseSuccess(Response::HTTP_OK, $movies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function search(Request $request): JsonResponse
    {
        try {
            $keyword = $request->keyword;
            $movies = $this->movieService->search($keyword);

            return $this->responseSuccess(Response::HTTP_OK, $movies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
