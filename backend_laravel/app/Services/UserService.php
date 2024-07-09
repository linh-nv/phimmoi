<?php

namespace App\Services;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(array $credentials): ?string
    {
        $user = [
            "email" => $credentials['email'],
            "password" => $credentials['password']
        ];
        if (!$token = Auth::attempt($user)) {
            return null;
        }

        return $token;
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

    public function logout () {
        Auth::guard('api')->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
        
        session()->invalidate();
        session()->regenerateToken();
    }
    

    public function refresh(): string
    {

        return Auth::refresh();
    }

    public function userProfile(): User
    {

        return Auth::user();
    }

    public function changePassword(string $newPassword): User
    {
        $auth = Auth::user();
        $user = User::findOrFail($auth->id);

        return $this->userRepository->update($user, [
            'password' => bcrypt($newPassword)
        ]);
    }

    public function createNewToken($token): array
    {

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user(),
        ];
    }
}
