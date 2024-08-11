<?php

namespace App\Services;

use App\Repositories\Admin\AdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\AdminRefreshToken;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminService
{
    protected AdminRepository $adminRepository;
    protected JWTService $jwtService;

    public function __construct(AdminRepository $adminRepository, JWTService $jwtService)
    {
        $this->adminRepository = $adminRepository;
        $this->jwtService = $jwtService;
    }

    /**
     * ============== JWT serivice =============    
     * */
    public function login($credentials)
    {
        if (! $token = auth()->guard('admin-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $admin = auth()->guard('admin-api')->user();

        return $this->jwtService->handleToken($token, $admin, AdminRefreshToken::class);
    }

    public function logout(): void
    {
        $auth = Auth::guard('admin-api');
        $user = $auth->user();
        $this->jwtService->revokeRefreshToken($user->id, AdminRefreshToken::class);
        $auth->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(): string
    {

        return Auth::guard('admin-api')->refresh();
    }

    public function adminProfile(): Admin
    {

        return Auth::guard('admin-api')->user();
    }
    /**
     * ====================================    
     * */

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
        $admin = Auth::guard('admin-api')->user();

        return $this->adminRepository->update($admin->id, [
            'password' => bcrypt($newPassword)
        ]);
    }
}
