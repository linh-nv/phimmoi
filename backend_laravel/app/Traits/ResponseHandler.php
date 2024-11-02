<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseHandler
{
    const SUCCESS_OK = 1;
    const SUCCESS_FALSE = 0;

    public function responseSuccess($code, $data = null): JsonResponse
    {
        $output = [
            'success' => self::SUCCESS_OK,
            'data' => $data,
        ];

        return response()->json($output, $code);
    }

    public function responseError($code, $errorCode, $message, $data = null): JsonResponse
    {
        $output = [
            'success' => self::SUCCESS_FALSE,
            'data' => $data,
            'errors' => [
                'error_code' => $errorCode,
                'error_message' => $message
            ]
        ];

        return response()->json($output, $code);
    }
}
