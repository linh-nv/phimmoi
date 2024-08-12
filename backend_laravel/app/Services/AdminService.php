<?php

namespace App\Services;

use App\Exceptions\RefreshTokenException;
use App\JWT\Admin\AdminJWT;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\AdminRefreshToken;
use Carbon\Carbon;
use Illuminate\Http\Response;
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
    public function login($credentials)
    {
        if (! $token = auth()->guard('admin-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        /** @var Admin $admin */
        $admin = auth()->guard('admin-api')->user();

        return $this->adminJWT->handleToken($token, $admin);
    }


    public function logout(): void
    {
        $auth = Auth::guard('admin-api');
        /** @var Admin $user */
        $user = $auth->user();

        $this->adminJWT->revokeRefreshToken($user);
        $auth->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(string $refreshToken): array
    {
        try {
            /** @var Admin $admin */
            $admin = $this->adminJWT->getUserFromRefreshToken($refreshToken);
            $accessToken = JWTAuth::fromUser($admin);
            $responseTokens = $this->adminJWT->handleToken($accessToken, $admin);

            return $responseTokens;
        } catch (\Exception $e) {

            throw new RefreshTokenException('Failed to refresh token: ' . $e->getMessage());
        }
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
