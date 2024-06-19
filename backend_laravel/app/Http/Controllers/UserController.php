<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Messages\ResponseMessages;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Traits\ResponseHandler;
use Illuminate\Http\Request;

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
        $token = $this->userService->login($credentials);

        if (!$token) {
            
            return $this->responseError(Response::HTTP_UNAUTHORIZED, 'UNAUTHORIZED', 'Unauthorized');
        }

        return $this->responseSuccess(Response::HTTP_OK, $this->userService->createNewToken($token));
   }

    public function register(UserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->register($request->all());

            return $this->responseSuccess(Response::HTTP_CREATED, $user);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('CREATE_ERROR'));
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->userService->logout();

            return $this->responseSuccess(Response::HTTP_OK, ['message' => 'User successfully signed out']);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', 'An error occurred while logging out.');
        }
    }

    public function refresh(): JsonResponse
    {
        try {
            $token = $this->userService->refresh();

            return $this->responseSuccess(Response::HTTP_OK, $this->userService->createNewToken($token));
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', 'An error occurred while refreshing the token.');
        }
    }

    public function userProfile(): JsonResponse
    {
        try {
            $user = $this->userService->userProfile();

            return $this->responseSuccess(Response::HTTP_OK, $user);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', ResponseMessages::getMessage('RETRIEVE_ERROR'));
        }
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $updatedUser = $this->userService->changePassword($request->new_password);

            return $this->responseSuccess(Response::HTTP_OK, $updatedUser);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', 'An error occurred while changing the password.');
        }
    }
}
