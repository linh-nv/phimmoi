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
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
                'email' => $data['email'],
                // 'phone' => $data['phone'] ?? null,
                'created_at' => Carbon::now(),
            ]);

            // $apiUrl = 'http://localhost:3001/api/v1/register';
            // $jwtSecret = env('JWT_SECRET');

            // if (!$jwtSecret) {
            //     throw new \Exception('JWT_SECRET không được cấu hình trong file .env');
            // }
            // $response = Http::withHeaders([
            //     'Authorization' => 'Bearer ' . $jwtSecret,
            //     'Content-Type' => 'application/json',
            //     'Accept' => 'application/json',
            // ])->post($apiUrl, [
            //     'id' => $user->id,
            //     'name' => $data['name'],
            //     'email' => $data['email'],
            //     'password' => Hash::make($data['password']),
            // ]);

            // if ($response->failed()) {
            //     DB::rollBack();
            //     Log::error('Đăng ký thất bại từ API NestJS: ' . $response->body());
            //     throw new \Exception('Đăng ký thất bại từ API NestJS', $response->status());
            // }
            // if (!$response->successful()) {
            //     DB::rollBack();

            //     throw new \Exception($response->json('message') ?? 'Đăng ký thất bại từ API NestJS', $response->status());
            // }

            DB::commit();

            return $user;
        } catch (QueryException $e) {
            DB::rollBack();
            Log::error('Lỗi cơ sở dữ liệu: ' . $e->getMessage());
            throw new \Exception('Lỗi cơ sở dữ liệu: ' . $e->getMessage(), 500);
        } catch (RequestException $e) {
            DB::rollBack();
            Log::error('Lỗi kết nối API: ' . $e->getMessage());
            throw new \Exception('Lỗi kết nối API: ' . $e->getMessage(), 500);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi không xác định: ' . $e->getMessage());
            throw new \Exception($e->getMessage(), 500);
        }
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
