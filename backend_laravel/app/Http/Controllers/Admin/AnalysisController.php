<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AnalysisService;
use App\Traits\ResponseHandler;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AnalysisController extends Controller
{
    use ResponseHandler;

    protected $analysisService;

    public function __construct(AnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    public function overview(): JsonResponse
    {
        try {
            $overview = $this->analysisService->getOverview();

            return $this->responseSuccess(Response::HTTP_OK, $overview);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }
}
