<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\EnumService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class EnumController extends Controller
{
    use ResponseHandler;

    protected EnumService $enumService;

    public function __construct(EnumService $enumService)
    {
        $this->enumService = $enumService;
    }

    public function getAllEnums(): JsonResponse
    {
        try {
            $enums = $this->enumService->getAllEnums();

            return $this->responseSuccess(Response::HTTP_OK, $enums);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function getMovieQuality(): JsonResponse
    {
        try {
            $qualities = $this->enumService->getMovieQuality();

            return $this->responseSuccess(Response::HTTP_OK, $qualities);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function getMovieStatus(): JsonResponse
    {
        try {
            $status = $this->enumService->getMovieStatus();

            return $this->responseSuccess(Response::HTTP_OK, $status);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function getMovieType(): JsonResponse
    {
        try {
            $types = $this->enumService->getMovieType();

            return $this->responseSuccess(Response::HTTP_OK, $types);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }

    public function getStatus(): JsonResponse
    {
        try {
            $status = $this->enumService->getStatus();

            return $this->responseSuccess(Response::HTTP_OK, $status);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
