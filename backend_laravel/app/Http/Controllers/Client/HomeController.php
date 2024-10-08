<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\HomeService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    use ResponseHandler;

    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(): JsonResponse
    {
        try {
            $home = $this->homeService->index();

            return $this->responseSuccess(Response::HTTP_OK, $home);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function header(): JsonResponse
    {
        try {
            $header = $this->homeService->header();

            return $this->responseSuccess(Response::HTTP_OK, $header);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function slider(): JsonResponse
    {
        try {
            $slider = $this->homeService->slider();

            return $this->responseSuccess(Response::HTTP_OK, $slider);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function filterOption(): JsonResponse
    {
        try {
            $filters = $this->homeService->filterOption();

            return $this->responseSuccess(Response::HTTP_OK, $filters);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
