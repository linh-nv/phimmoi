<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieRequest;
use App\Messages\ResponseMessages;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandler;
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

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
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

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('CREATE_ERROR'));
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

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MovieRequest $request, Movie $movie): JsonResponse
    {
        try {
            $movie = $this->movieService->updateMovie($movie, $request->all());

            return $this->responseSuccess(Response::HTTP_OK, $movie);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('UPDATE_ERROR'));
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
            $this->movieService->destroyMultiple($ids);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('DELETE_ERROR'));
        }
    }
}
