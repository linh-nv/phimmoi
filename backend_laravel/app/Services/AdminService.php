<?php

namespace App\Services;

use App\JWT\Admin\AdminJWT;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminService
{
    protected AdminRepository $adminRepository;
    protected AdminJWT $adminJWT;

    public function __construct(AdminRepository $adminRepository, AdminJWT $adminJWT)
    {
        $this->adminRepository = $adminRepository;
        $this->adminJWT = $adminJWT;
    }

    /**
     * ============== JWT service =============    
     * */
    public function login($credentials): ?array
    {
        if (!$token = auth()->guard('admin-api')->attempt($credentials)) {
            
            return null;
        }

        /** @var Admin $admin */
        $admin = auth()->guard('admin-api')->user();

        return $this->adminJWT->handleToken($token, $admin);
    }


    public function logout(): void
    {
        $auth = Auth::guard('admin-api');
        $user = $auth->user();

        $this->adminJWT->revokeRefreshToken($user->id);
        $auth->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(string $refreshToken): array
    {
        $payload = JWTAuth::setToken($refreshToken)->getPayload();
        $adminId = $payload['sub'];
        $admin = $this->adminRepository->find($adminId);
        $this->adminJWT->checkRefreshToken($admin, $refreshToken);
        $accessToken = JWTAuth::fromUser($admin);

        return $this->adminJWT->handleToken($accessToken, $admin);
    }
    /**
     * ====================================    
     * */

    public function adminProfile(): Admin
    {

        return Auth::guard('admin-api')->user();
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

    public function changePassword(string $newPassword): Admin
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin-api')->user();

        return $this->adminRepository->update($admin, [
            'password' => bcrypt($newPassword)
        ]);
    }
}
