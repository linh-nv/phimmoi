<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\AdminRequest;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use ResponseHandler;

    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $token = $this->adminService->login($credentials);

        if (!$token) {

            return $this->responseError(Response::HTTP_UNAUTHORIZED, 'UNAUTHORIZED', 'Unauthorized');
        }

        return $this->responseSuccess(Response::HTTP_OK, $token);
    }

    public function register(AdminRequest $request): JsonResponse
    {
        try {
            $admin = $this->adminService->register($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $admin);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->adminService->logout();

            return $this->responseSuccess(Response::HTTP_OK, ['message' => 'Admin successfully signed out']);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function refresh(Request $request): JsonResponse
    {
        try {
            $refreshToken = $request->refresh_token;
            $refresh = $this->adminService->refresh($refreshToken);
            
            return $this->responseSuccess(Response::HTTP_OK, $refresh);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function adminProfile(): JsonResponse
    {
        try {
            $admin = $this->adminService->adminProfile();

            return $this->responseSuccess(Response::HTTP_OK, $admin);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $updatedAdmin = $this->adminService->changePassword($request->new_password);

            return $this->responseSuccess(Response::HTTP_OK, $updatedAdmin);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }
}
