<?php

namespace App\Services;

use App\Repositories\Admin\AdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminService
{
    protected AdminRepository $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function login(array $credentials): ?string
    {
        $adminCredentials = [
            "email" => $credentials['email'],
            "password" => $credentials['password']
        ];

        if (!$token = Auth::guard('admin-api')->attempt($adminCredentials)) {

            return null;
        }

        return $token;
    }

    public function register(array $data): Admin
    {

        return $this->adminRepository->create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'created_at' => Carbon::now(),
        ]);
    }

    public function logout(): void
    {
        Auth::guard('admin-api')->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
        
        session()->invalidate();
        session()->regenerateToken();
    }

    public function refresh(): string
    {
        
        return Auth::guard('admin-api')->refresh();
    }

    public function adminProfile(): Admin
    {

        return Auth::guard('admin-api')->user();
    }

    public function changePassword(string $newPassword): Admin
    {
        $admin = Auth::guard('admin-api')->user();

        return $this->adminRepository->update($admin, [
            'password' => bcrypt($newPassword)
        ]);
    }

    public function createNewToken($token): array
    {

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('admin-api')->factory()->getTTL() * 60,
            'admin' => Auth::guard('admin-api')->user(),
        ];
    }
}
