<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repositories\User\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Traits\ResponseHandler;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller implements HasMiddleware
{

    use ResponseHandler;

    protected UserRepository $userRepository;

    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['login', 'register']),
        ];
    }

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request): JsonResponse
    {
        $user = [
            "email" => $request->email,
            "password" => $request->password
        ];

        if (!$token = Auth::attempt($user)) {

            return $this->responseError(Response::HTTP_UNAUTHORIZED, 'UNAUTHORIZED', 'Unauthorized');
        }

        return $this->createNewToken($token);
    }

    public function register(UserRequest $request): JsonResponse
    {
        try {
            $user = $this->userRepository->create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email' => $request->email,
                'phone' => $request->phone ?? null,
                'created_at' => Carbon::now(),
            ]);

            return $this->responseSuccess(Response::HTTP_CREATED, $user);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', 'An error occurred while deleting the Country.');
        }
    }

    public function logout(): JsonResponse
    {
        try {
            Auth::logout();

            return $this->responseSuccess(Response::HTTP_OK, ['message' => 'User successfully signed out']);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', 'An error occurred while deleting the Country.');
        }
    }

    public function refresh(): JsonResponse
    {
        try {
            $newToken = $this->createNewToken(Auth::refresh());

            return $this->responseSuccess(Response::HTTP_OK, $newToken);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', 'An error occurred while deleting the Country.');
        }
    }

    public function userProfile(): JsonResponse
    {
        try {
            $user = Auth::user();

            return $this->responseSuccess(Response::HTTP_OK, $user);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', 'An error occurred while deleting the Country.');
        }
    }

    protected function createNewToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }

    public function changePassWord(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|string|min:6',
                'new_password' => 'required|string|confirmed|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), Response::HTTP_BAD_REQUEST);
            }

            $user = User::where('id', Auth::user()->id)->first();
            $user = $this->userRepository->update($user, [
                'password' => bcrypt($request->new_password)
            ]);

            return $this->responseSuccess(Response::HTTP_OK, $user);
        } catch (\Exception $e) {

            return $this->responseError(Response::HTTP_INTERNAL_SERVER_ERROR, 'INTERNAL_ERROR', 'An error occurred while deleting the Country.');
        }
    }
}
