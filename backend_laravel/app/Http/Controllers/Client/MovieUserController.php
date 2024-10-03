<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\MovieUserRequest;
use App\Services\Client\MovieUserService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class MovieUserController extends Controller
{
    use ResponseHandler;

    protected $movieUserService;

    public function __construct(MovieUserService $movieUserService)
    {
        $this->movieUserService = $movieUserService;
    }

    public function getAll($id): JsonResponse
    {
        try {
            $movies = $this->movieUserService->getMovies($id);

            return $this->responseSuccess(Response::HTTP_OK, $movies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function create(MovieUserRequest $request): JsonResponse
    {
        try {
            $movieId = $request->movie_id;
            $movieUser = $this->movieUserService->create($movieId);

            return $this->responseSuccess(Response::HTTP_OK, $movieUser);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function exist($movieId): JsonResponse
    {
        try {
            $movieUser = $this->movieUserService->exist($movieId);

            return $this->responseSuccess(Response::HTTP_OK, $movieUser);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
