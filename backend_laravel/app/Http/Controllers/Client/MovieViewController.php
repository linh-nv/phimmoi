<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\MovieViewService;
use App\Traits\ResponseHandler;
use Illuminate\Http\Response;

class MovieViewController extends Controller
{
    use ResponseHandler;

    protected $movieViewService;

    public function __construct(MovieViewService $movieViewService)
    {
        $this->movieViewService = $movieViewService;
    }

    public function moviesDay()
    {
        try {
            $movies = $this->movieViewService->moviesDay();

            return $this->responseSuccess(Response::HTTP_OK, $movies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function moviesWeek()
    {
        try {
            $movies = $this->movieViewService->moviesWeek();

            return $this->responseSuccess(Response::HTTP_OK, $movies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function moviesMonth()
    {
        try {
            $movies = $this->movieViewService->moviesMonth();

            return $this->responseSuccess(Response::HTTP_OK, $movies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function moviesYear()
    {
        try {
            $movies = $this->movieViewService->moviesYear();

            return $this->responseSuccess(Response::HTTP_OK, $movies);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
