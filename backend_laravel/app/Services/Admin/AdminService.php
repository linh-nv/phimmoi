<?php

namespace App\Services\Admin;

use App\JWT\Admin\AdminJWT;
use App\Repositories\Admin\AdminRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
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

    public function getAll()
    {

        return $this->adminRepository->getPaginate();
    }
    /**
     * ============== JWT service =============    
     * */
    public function login($credentials): ?Collection
    {
        if (!$token = auth()->guard('admin-api')->attempt($credentials)) {

            return null;
        }

        /** @var Admin $admin */
        $admin = auth()->guard('admin-api')->user();

        $data = $this->adminJWT->handleToken($token, $admin);

        return collect($data);
    }


    public function logout(): void
    {
        $auth = Auth::guard('admin-api');
        $user = $auth->user();

        $this->adminJWT->revokeRefreshToken($user->id);
        $auth->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function refresh(string $refreshToken): Collection
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

    public function adminProfile(): Authenticatable|null
    {

        return Auth::guard('admin-api')->user();
    }

    public function register(array $data): Model
    {

        return $this->adminRepository->create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'created_at' => Carbon::now(),
        ]);
    }

    public function changePassword(string $oldPassword, string $newPassword): ?Model
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin-api')->user();

        if (!Hash::check($oldPassword, $admin->password)) {

            return null;
        }

        return $this->adminRepository->update($admin, [
            'password' => Hash::make($newPassword)
        ]);
    }

    public function delete(int $id)
    {
        $admin = $this->adminRepository->find($id);

        if (!$admin) {
            throw new \Exception('Admin not found');
        }

        if ($admin->id === Auth::guard('admin-api')->id()) {
            throw new \Exception('You cannot delete yourself');
        }

        return $this->adminRepository->delete($admin);
    }
}
