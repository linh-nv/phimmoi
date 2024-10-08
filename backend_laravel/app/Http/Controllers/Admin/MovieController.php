<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Models\Movie;
use App\Services\Admin\MovieService;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    use ResponseHandler;

    protected $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $keyword = $request->query('keyword');

        try {
            $categories = $this->movieService->getPaginate($keyword);

            return $this->responseSuccess(Response::HTTP_OK, $categories);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MovieRequest $request): JsonResponse
    {
        try {
            $movie = $this->movieService->createMovie($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $movie);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): JsonResponse
    {
        try {
            $movie = $this->movieService->getMovieById($movie);

            return $this->responseSuccess(Response::HTTP_OK, $movie);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug): JsonResponse
    {
        try {
            $movie = $this->movieService->updateMovie($slug, $request->all());

            return $this->responseSuccess(Response::HTTP_OK, $movie);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie): JsonResponse
    {
        try {
            $this->movieService->deleteMovie($movie);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    /**
     * Remove the multi resource from storage.
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $ids = $request->input('ids');

        try {
            $this->movieService->destroyMultiple($ids);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }
}
