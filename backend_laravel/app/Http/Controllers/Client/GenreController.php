<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\GenreService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenreController extends Controller
{
    use ResponseHandler;

    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    public function index($slug): JsonResponse
    {
        try {
            $genreMovies = $this->genreService->index($slug);

            return $this->responseSuccess(Response::HTTP_OK, $genreMovies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
