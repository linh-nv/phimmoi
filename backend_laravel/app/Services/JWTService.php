<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTService
{
    /**
     * Handle create and save refresh token; respone detail user information, access, refresh token
     */
    public function handleToken(string $token, Model $user, string $refreshTokenModel): array
    {
        $refreshToken = $this->genarateRefreshToken($user);
        $this->saveRefreshToken($refreshToken, $user, $refreshTokenModel);

        return $this->responseWithToken($token, $refreshToken, $user);
    }

    /**
     * Save refresh token into database
     */
    private function saveRefreshToken(string $refreshToken, Model $user, string $refreshTokenModel): void
    {

        $refreshTokenModel::updateOrCreate(
            [
                'user_id' => $user->id
            ],
            [
                'token' => $refreshToken,
                'user_id' => $user->id,
                'expires_at' => Carbon::now()->addDays(30),
            ]
        );

    }

    /**
     * Create refresh token
     */
    public function genarateRefreshToken(Model $user): string
    {
        $refreshToken = JWTAuth::fromUser($user, ['type' => 'refresh']);

        return $refreshToken;
    }

    /**
     * Revoke refresh token
     */
    public function revokeRefreshToken($user_id, string $refreshTokenModel): void
    {
        $refreshTokenModel::where('user_id', $user_id)->delete();
    }

    /**
     * Response detail user, access token, refresh token, expires time
     */
    public function responseWithToken(string $token, string $refreshToken, Model $user): array
    {

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl'),
            'refresh_token' => $refreshToken,
            'data' => $user,
        ];
    }
}
