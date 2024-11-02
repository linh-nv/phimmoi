<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CountryService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    use ResponseHandler;

    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function index($slug): JsonResponse
    {
        try {
            $moviesCountry = $this->countryService->index($slug);

            return $this->responseSuccess(Response::HTTP_OK, $moviesCountry);
        } catch (\Throwable $th) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $th->getMessage());
        }
    }
}
