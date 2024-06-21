<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenreRequest;
use App\Messages\ResponseMessages;
use App\Models\Genre;
use App\Services\GenreService;
use Illuminate\Http\JsonResponse;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GenreController extends Controller
{
    use ResponseHandler;

    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $keyword = $request->query('keyword');

        try {
            $categories = $this->genreService->getPaginate($keyword);

            return $this->responseSuccess(Response::HTTP_OK, $categories);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GenreRequest $request): JsonResponse
    {
        try {
            $genre = $this->genreService->createGenre($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $genre);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('CREATE_ERROR'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre): JsonResponse
    {
        try {
            $genre = $this->genreService->getGenreById($genre);

            return $this->responseSuccess(Response::HTTP_OK, $genre);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GenreRequest $request, Genre $genre): JsonResponse
    {
        try {
            $genre = $this->genreService->updateGenre($genre, $request->all());

            return $this->responseSuccess(Response::HTTP_OK, $genre);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('UPDATE_ERROR'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre): JsonResponse
    {
        try {
            $this->genreService->deleteGenre($genre);

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
            $this->genreService->destroyMultiple($ids);

            return $this->responseSuccess(Response::HTTP_OK, null);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('DELETE_ERROR'));
        }
    }
}
