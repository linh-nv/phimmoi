<?php

namespace App\Services\Admin;

use App\JWT\User\UserJWT;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    protected UserRepository $userRepository;
    protected UserJWT $userJWT;

    public function __construct(UserRepository $userRepository, UserJWT $userJWT)
    {
        $this->userRepository = $userRepository;
        $this->userJWT = $userJWT;
    }

    /**
     * ============== JWT service =============    
     * */
    public function login($credentials): ?Collection
    {
        if (!$token = auth()->guard('api')->attempt($credentials)) {

            return null;
        }

        /** @var User $user */
        $user = auth()->guard('api')->user();
        $data = $this->userJWT->handleToken($token, $user);

        return collect($data);
    }


    public function logout(): void
    {
        $auth = Auth::guard('api');
        $user = $auth->user();

        $this->userJWT->revokeRefreshToken($user->id);
        $auth->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(string $refreshToken): Collection
    {
        $payload = JWTAuth::setToken($refreshToken)->getPayload();
        $userId = $payload['sub'];
        $user = $this->userRepository->find($userId);
        $this->userJWT->checkRefreshToken($user, $refreshToken);
        $accessToken = JWTAuth::fromUser($user);

        return collect($this->userJWT->handleToken($accessToken, $user));
    }
    /**
     * ====================================    
     * */

    public function userProfile(): User
    {

        return Auth::guard('api')->user();
    }

    public function register(array $data): User
    {

        return $this->userRepository->create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'created_at' => Carbon::now(),
        ]);
    }

    public function changePassword(string $newPassword): User
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        return $this->userRepository->update($user, [
            'password' => bcrypt($newPassword)
        ]);
    }
}
