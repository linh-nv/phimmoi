<?php

namespace App\Services\Admin;

use App\JWT\User\UserJWT;
use App\Mail\VerificationEmail;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\VerificationService;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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

    public function userProfile(): Authenticatable|null
    {

        return Auth::guard('api')->user();
    }

    public function handleRegister(array $data): bool|Model
    {
        $verificationService = new VerificationService();
        if (!isset($data['verification_code'])) {
            $verificationService->sendVerificationCode($data['email']);
            return true;
        }

        $isCodeValid = $verificationService->verifyCode($data['email'], $data['verification_code']);
        if (!$isCodeValid) {
            return false;
        }

        return $this->register($data);
    }
    public function register(array $data): Model
    {

        return $this->userRepository->create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'created_at' => Carbon::now(),
        ]);
    }

    public function changePassword(string $newPassword): Model
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        return $this->userRepository->update($user, [
            'password' => bcrypt($newPassword)
        ]);
    }


    public function registerViaGoogle($googleUser)
    {
        return DB::transaction(function () use ($googleUser) {

            // Kiểm tra xem người dùng đã tồn tại hay chưa
            $user = $this->userRepository->findByEmail($googleUser->getEmail());

            if (!$user) {
                // Nếu chưa có tài khoản, tạo tài khoản tạm thời và gửi mã xác nhận
                $user = $this->userRepository->create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => null, // Không cần mật khẩu vì đăng nhập bằng Google
                    'is_verified' => false, // Chưa xác nhận
                    'created_at' => Carbon::now(),
                ]);
            }

            // Tạo mã xác nhận ngẫu nhiên
            $verificationCode = Str::random(6);

            // Lưu mã xác nhận vào bảng email_verifications
            DB::table('email_verifications')->updateOrInsert(
                ['email' => $googleUser->getEmail()],
                [
                    'verification_code' => $verificationCode,
                    'verified' => false,
                    'created_at' => now(),
                ]
            );

            // Gửi email xác nhận
            Mail::to($googleUser->getEmail())->send(new VerificationEmail($verificationCode));

            return $user;
        });
    }
}
