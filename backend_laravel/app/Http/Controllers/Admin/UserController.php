<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Services\Admin\UserService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    use ResponseHandler;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $user = $this->userService->login($credentials);

        if (!$user) {

            return $this->responseError(Response::HTTP_UNAUTHORIZED, 'UNAUTHORIZED', 'Unauthorized');
        }

        return $this->responseSuccess(Response::HTTP_OK, $user);
    }

    public function register(UserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->handleRegister($request->all());
            if (!$user) {

                return $this->responseError(Response::HTTP_UNPROCESSABLE_ENTITY, 'INVALID_VERIFICATION_CODE', 'The verification code is either invalid or expired.');
            }

            return $this->responseSuccess(Response::HTTP_CREATED, $user);
        } catch (\Throwable $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->userService->logout();

            return $this->responseSuccess(Response::HTTP_OK, ['message' => 'User successfully signed out']);
        } catch (\Throwable $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function refresh(Request $request): JsonResponse
    {
        try {
            $refreshToken = $request->refresh_token;
            $refresh = $this->userService->refresh((string) $refreshToken);

            return $this->responseSuccess(Response::HTTP_OK, $refresh);
        } catch (\Throwable $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function userProfile(): JsonResponse
    {
        try {
            $user = $this->userService->userProfile();

            return $this->responseSuccess(Response::HTTP_OK, $user);
        } catch (\Throwable $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $updatedUser = $this->userService->changePassword($request->new_password);

            return $this->responseSuccess(Response::HTTP_OK, $updatedUser);
        } catch (\Throwable $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', $e->getMessage());
        }
    }

    public function redirect(Request $request)
    {
        $refresh = $this->userService->refresh($request->refreshToken);
        $token = $refresh['data']['refresh_token'];

        $reactAppUrl = env(key: 'REACT_APP_URL', default: 'http://localhost:5173');
        $redirectUrl = $reactAppUrl . '/auth/callback';

        Http::get($redirectUrl, [
            'token' => $token,
        ]);
    }
}
