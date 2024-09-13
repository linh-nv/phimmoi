<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\MovieUserService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovieUserController extends Controller
{
    use ResponseHandler;

    protected $movieUserService;

    public function __construct(MovieUserService $movieUserService)
    {
        $this->movieUserService = $movieUserService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $userId = $request->id;
            $movies = $this->movieUserService->getMovies($userId);

            return $this->responseSuccess(Response::HTTP_OK, $movies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
