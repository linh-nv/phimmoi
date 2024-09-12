<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\HomeService;
use App\Traits\ResponseHandler;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    use ResponseHandler;

    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        try {
            $home = $this->homeService->index();

            return $this->responseSuccess(Response::HTTP_OK, $home);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function header()
    {
        try {
            $header = $this->homeService->header();

            return $this->responseSuccess(Response::HTTP_OK, $header);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function slider()
    {
        try {
            $slider = $this->homeService->slider();

            return $this->responseSuccess(Response::HTTP_OK, $slider);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
